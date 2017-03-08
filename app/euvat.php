<?php
/**
 * EU Vat helper functions
 *
 * @category   Helper
 * @author     Chema <chema@garridodiaz.com>
 * @copyright  (c) 2016
 * @license    GPL v3
 */

namespace App;
use Cache;
use GeoIp2\Database\Reader;

class euvat {

    
    /**
     * gets the country code from the user
     * @param  string $ip_address 
     * @param Request $request
     * @return array             
     */
    public static function countryCodeByIP($ipaddress, $request)
    {
        $countryCode = NULL;

        //hack to detect the clients ip...nasty
        if ($ipaddress === 'detect')
        {
            $ipaddress = $request->ip();

            //cloudflare hack saves geoip search ;)
            if (!empty($_SERVER["HTTP_CF_IPCOUNTRY"]))
                $countryCode = $_SERVER["HTTP_CF_IPCOUNTRY"];
        }

        //only if we do not have the country code use geoi
        if ($countryCode === NULL)
        {
            //USAGE of cache!!
            $key = 'countryCodeByIP::'.$ipaddress;

            if ( ($countryCode = Cache::get($key)) == NULL )
            {
                $reader = new Reader(storage_path().'/GeoLite2-Country.mmdb');

                try {
                    $record = $reader->country($ipaddress);//'91.126.239.140'
                    $countryCode = $record->country->isoCode;
                } catch (\Exception $e) {
                    $countryCode = NULL;
                }

                Cache::put($key,$countryCode,30*24*60);//30 days cached
            }
        }

        //we could not resolve the country for this ip...
        if ($countryCode === NULL)
            return ['result' => FALSE, 'message' => 'country code not found', 'ip_address' => $ipaddress ];
        else
            return  [
                    'country_code'  => $countryCode,
                    'country_name'  => euvat::countryName($countryCode),
                    'vat'           => euvat::vatByCountry($countryCode),
                    'ip_address'    => $ipaddress
                    ];
    }



    /**
     * get country name from a country code, in case not set get by ip
     * @param  string $countryCode [description]
     * @param  string $ip_address 
     * @return array
     */
    public static function countryName($countryCode = NULL, $ip_address = NULL)
    {
        if ($countryCode===NULL OR empty($countryCode))
            $countryCode = euvat::countryCodeByIP($ip_address);

        return (isset(euvat::$countries[$countryCode]))?euvat::$countries[$countryCode]:NULL;
    }

    /**
     * verifies vies number
     * @param  string $vatNumber   
     * @param  string $countryCode 
     * @return array               
     */
    public static function validate($vatNumber)
    {
        $result = euvat::companyInfo($vatNumber)['valid'];
        return [ 'valid' => $result ];
    }

    /**
     * gets all the company info
     * @param  string $vatNumber 
     * @return array            
     */
    public static function companyInfo($vatNumber)
    {
        $countryCode = strtoupper(substr($vatNumber,0,2));
        $vatNumber   = substr($vatNumber,2);

        //first check if country is part of EU 
        if ( strlen($countryCode)==2 AND strlen($vatNumber)>=2 AND (array_key_exists($countryCode, euvat::getVatRates())) )
        {
            //USAGE of cache!!
            $key = 'companyInfo::'.$countryCode.$vatNumber;

            if ( ($result = Cache::get($key)) == NULL )
            {
                $client = new \SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
                $result = $client->checkVatApprox(array('countryCode' => $countryCode,'vatNumber' => $vatNumber));
                Cache::put($key,$result,30*24*60);//30 days cached
            }
            
            //valid
            if ($result->valid == TRUE)
            {
                //cast result to array
                $result = (array) $result;
                unset($result['requestIdentifier']);

                //get vat rates
                $result['vat'] = euvat::vatByCountry($countryCode);

                return $result;
            }
        }        

        return ['valid' => FALSE , 'message' => 'wrong VAT number or not found'];
    }

    /**
     * its a valid vat country?
     * @param  string  $countryCode 
     * @return array               
     */
    public static function isEUcountry($countryCode)
    {   
        $rate = euvat::vatByCountry($countryCode);

        return  [
                    'is_eu_country' => ($rate!==FALSE) ? TRUE  :FALSE,
                    'VAT'           => ($rate!==FALSE) ? $rate : NULL
                ];
    }

    /**
     * get VAT for the copuntry
     * @param  strinf  $countryCode 
     * @return array               
     */
    public static function vatByCountry($countryCode)
    {
        $eu_rate = euvat::getVatRates();

        $countryCode = strtoupper($countryCode);

        if ( isset($eu_rate[$countryCode]) AND  is_numeric($eu_rate[$countryCode]['standard_rate']) )
        {
            $vatRate = $eu_rate[$countryCode];
            unset($vatRate['_comment']);
            unset($vatRate['country']);
            unset($vatRate['iso_duplicate_of']);

            return $vatRate;
        }
        else 
            return FALSE;
    }

    /**
     * calculates how much you need to pay to a country
     * @param  string $countryCode 
     * @param  number $amount      
     * @return array              
     */
    public static function calc($countryCode, $amount)
    {
        $total = FALSE;

        $rate = euvat::vatByCountry($countryCode);

        if ($rate !== FALSE AND is_numeric($amount))
        {
            $vat    = ($rate['standard_rate'] * $amount / 100);
            $total  = $amount + $vat;

            return ['result' => $total , 'vat_applied' => $vat, 'standard_rate' => $rate['standard_rate']];
        }    
        
        return ['result' => FALSE, 'message' => 'country code not found or wrong amount'];
    }


    /**
     * return all the EU vat rates as array from the json
     * @param  boolean $reload forces reload
     * @return array          
     */
    public static function getVatRates($reload = FALSE)
    {
        //we check the date of our local versions.php
        $vat_rates_file = realpath(dirname(__FILE__)).'/../public/rates.json';

        //if older than a month or ?reload=1 force reload
        if (!file_exists($vat_rates_file) OR time() > strtotime('+1 month',filemtime($vat_rates_file)) OR $reload === TRUE )
        {
            //read from external source http://wceuvatcompliance.s3.amazonaws.com/rates.json OR https://euvatrates.com/rates.json
            $file = file_get_contents('https://wceuvatcompliance.s3.amazonaws.com/rates.json?r='.time());
            
            if ($file!==NULL)
                file_put_contents($vat_rates_file, $file);
        }

        //return only the rates
        $rates = json_decode(file_get_contents($vat_rates_file),TRUE);

        return $rates['rates'];
    }


    /**
     * Array of country codes (ISO 3166-1 alpha-2) and corresponding names
     * @see https://gist.github.com/vxnick/380904
     * @var array
     */
    public static $countries = array
    (
    'AF' => 'Afghanistan',
    'AX' => 'Aland Islands',
    'AL' => 'Albania',
    'DZ' => 'Algeria',
    'AS' => 'American Samoa',
    'AD' => 'Andorra',
    'AO' => 'Angola',
    'AI' => 'Anguilla',
    'AQ' => 'Antarctica',
    'AG' => 'Antigua And Barbuda',
    'AR' => 'Argentina',
    'AM' => 'Armenia',
    'AW' => 'Aruba',
    'AU' => 'Australia',
    'AT' => 'Austria',
    'AZ' => 'Azerbaijan',
    'BS' => 'Bahamas',
    'BH' => 'Bahrain',
    'BD' => 'Bangladesh',
    'BB' => 'Barbados',
    'BY' => 'Belarus',
    'BE' => 'Belgium',
    'BZ' => 'Belize',
    'BJ' => 'Benin',
    'BM' => 'Bermuda',
    'BT' => 'Bhutan',
    'BO' => 'Bolivia',
    'BA' => 'Bosnia And Herzegovina',
    'BW' => 'Botswana',
    'BV' => 'Bouvet Island',
    'BR' => 'Brazil',
    'IO' => 'British Indian Ocean Territory',
    'BN' => 'Brunei Darussalam',
    'BG' => 'Bulgaria',
    'BF' => 'Burkina Faso',
    'BI' => 'Burundi',
    'KH' => 'Cambodia',
    'CM' => 'Cameroon',
    'CA' => 'Canada',
    'CV' => 'Cape Verde',
    'KY' => 'Cayman Islands',
    'CF' => 'Central African Republic',
    'TD' => 'Chad',
    'CL' => 'Chile',
    'CN' => 'China',
    'CX' => 'Christmas Island',
    'CC' => 'Cocos (Keeling) Islands',
    'CO' => 'Colombia',
    'KM' => 'Comoros',
    'CG' => 'Congo',
    'CD' => 'Congo, Democratic Republic',
    'CK' => 'Cook Islands',
    'CR' => 'Costa Rica',
    'CI' => 'Cote D\'Ivoire',
    'HR' => 'Croatia',
    'CU' => 'Cuba',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'DK' => 'Denmark',
    'DJ' => 'Djibouti',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'EC' => 'Ecuador',
    'EG' => 'Egypt',
    'SV' => 'El Salvador',
    'GQ' => 'Equatorial Guinea',
    'ER' => 'Eritrea',
    'EE' => 'Estonia',
    'ET' => 'Ethiopia',
    'FK' => 'Falkland Islands (Malvinas)',
    'FO' => 'Faroe Islands',
    'FJ' => 'Fiji',
    'FI' => 'Finland',
    'FR' => 'France',
    'GF' => 'French Guiana',
    'PF' => 'French Polynesia',
    'TF' => 'French Southern Territories',
    'GA' => 'Gabon',
    'GM' => 'Gambia',
    'GE' => 'Georgia',
    'DE' => 'Germany',
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GR' => 'Greece',
    'GL' => 'Greenland',
    'GD' => 'Grenada',
    'GP' => 'Guadeloupe',
    'GU' => 'Guam',
    'GT' => 'Guatemala',
    'GG' => 'Guernsey',
    'GN' => 'Guinea',
    'GW' => 'Guinea-Bissau',
    'GY' => 'Guyana',
    'HT' => 'Haiti',
    'HM' => 'Heard Island & Mcdonald Islands',
    'VA' => 'Holy See (Vatican City State)',
    'HN' => 'Honduras',
    'HK' => 'Hong Kong',
    'HU' => 'Hungary',
    'IS' => 'Iceland',
    'IN' => 'India',
    'ID' => 'Indonesia',
    'IR' => 'Iran, Islamic Republic Of',
    'IQ' => 'Iraq',
    'IE' => 'Ireland',
    'IM' => 'Isle Of Man',
    'IL' => 'Israel',
    'IT' => 'Italy',
    'JM' => 'Jamaica',
    'JP' => 'Japan',
    'JE' => 'Jersey',
    'JO' => 'Jordan',
    'KZ' => 'Kazakhstan',
    'KE' => 'Kenya',
    'KI' => 'Kiribati',
    'KR' => 'Korea',
    'KW' => 'Kuwait',
    'KG' => 'Kyrgyzstan',
    'LA' => 'Lao People\'s Democratic Republic',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LS' => 'Lesotho',
    'LR' => 'Liberia',
    'LY' => 'Libyan Arab Jamahiriya',
    'LI' => 'Liechtenstein',
    'LT' => 'Lithuania',
    'LU' => 'Luxembourg',
    'MO' => 'Macao',
    'MK' => 'Macedonia',
    'MG' => 'Madagascar',
    'MW' => 'Malawi',
    'MY' => 'Malaysia',
    'MV' => 'Maldives',
    'ML' => 'Mali',
    'MT' => 'Malta',
    'MH' => 'Marshall Islands',
    'MQ' => 'Martinique',
    'MR' => 'Mauritania',
    'MU' => 'Mauritius',
    'YT' => 'Mayotte',
    'MX' => 'Mexico',
    'FM' => 'Micronesia, Federated States Of',
    'MD' => 'Moldova',
    'MC' => 'Monaco',
    'MN' => 'Mongolia',
    'ME' => 'Montenegro',
    'MS' => 'Montserrat',
    'MA' => 'Morocco',
    'MZ' => 'Mozambique',
    'MM' => 'Myanmar',
    'NA' => 'Namibia',
    'NR' => 'Nauru',
    'NP' => 'Nepal',
    'NL' => 'Netherlands',
    'AN' => 'Netherlands Antilles',
    'NC' => 'New Caledonia',
    'NZ' => 'New Zealand',
    'NI' => 'Nicaragua',
    'NE' => 'Niger',
    'NG' => 'Nigeria',
    'NU' => 'Niue',
    'NF' => 'Norfolk Island',
    'MP' => 'Northern Mariana Islands',
    'NO' => 'Norway',
    'OM' => 'Oman',
    'PK' => 'Pakistan',
    'PW' => 'Palau',
    'PS' => 'Palestinian Territory, Occupied',
    'PA' => 'Panama',
    'PG' => 'Papua New Guinea',
    'PY' => 'Paraguay',
    'PE' => 'Peru',
    'PH' => 'Philippines',
    'PN' => 'Pitcairn',
    'PL' => 'Poland',
    'PT' => 'Portugal',
    'PR' => 'Puerto Rico',
    'QA' => 'Qatar',
    'RE' => 'Reunion',
    'RO' => 'Romania',
    'RU' => 'Russian Federation',
    'RW' => 'Rwanda',
    'BL' => 'Saint Barthelemy',
    'SH' => 'Saint Helena',
    'KN' => 'Saint Kitts And Nevis',
    'LC' => 'Saint Lucia',
    'MF' => 'Saint Martin',
    'PM' => 'Saint Pierre And Miquelon',
    'VC' => 'Saint Vincent And Grenadines',
    'WS' => 'Samoa',
    'SM' => 'San Marino',
    'ST' => 'Sao Tome And Principe',
    'SA' => 'Saudi Arabia',
    'SN' => 'Senegal',
    'RS' => 'Serbia',
    'SC' => 'Seychelles',
    'SL' => 'Sierra Leone',
    'SG' => 'Singapore',
    'SK' => 'Slovakia',
    'SI' => 'Slovenia',
    'SB' => 'Solomon Islands',
    'SO' => 'Somalia',
    'ZA' => 'South Africa',
    'GS' => 'South Georgia And Sandwich Isl.',
    'ES' => 'Spain',
    'LK' => 'Sri Lanka',
    'SD' => 'Sudan',
    'SR' => 'Suriname',
    'SJ' => 'Svalbard And Jan Mayen',
    'SZ' => 'Swaziland',
    'SE' => 'Sweden',
    'CH' => 'Switzerland',
    'SY' => 'Syrian Arab Republic',
    'TW' => 'Taiwan',
    'TJ' => 'Tajikistan',
    'TZ' => 'Tanzania',
    'TH' => 'Thailand',
    'TL' => 'Timor-Leste',
    'TG' => 'Togo',
    'TK' => 'Tokelau',
    'TO' => 'Tonga',
    'TT' => 'Trinidad And Tobago',
    'TN' => 'Tunisia',
    'TR' => 'Turkey',
    'TM' => 'Turkmenistan',
    'TC' => 'Turks And Caicos Islands',
    'TV' => 'Tuvalu',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'AE' => 'United Arab Emirates',
    'GB' => 'United Kingdom',
    'US' => 'United States',
    'UM' => 'United States Outlying Islands',
    'UY' => 'Uruguay',
    'UZ' => 'Uzbekistan',
    'VU' => 'Vanuatu',
    'VE' => 'Venezuela',
    'VN' => 'Viet Nam',
    'VG' => 'Virgin Islands, British',
    'VI' => 'Virgin Islands, U.S.',
    'WF' => 'Wallis And Futuna',
    'EH' => 'Western Sahara',
    'YE' => 'Yemen',
    'ZM' => 'Zambia',
    'ZW' => 'Zimbabwe',
    );


  
    
}
