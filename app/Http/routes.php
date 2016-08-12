<?php
use App\euvat;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return view('home');
    //return $app->version();
});


$app->group(['prefix' => 'api/v1','namespace' => 'Http\Controllers'], function($app)
{

    //full info for that company
    $app->get('info/{countryCode}/{vatnumber}',function($countryCode,$vatnumber){
        return euvat::companyInfo($vatnumber,$countryCode);
    });  

    //just tell me if the company is EU
    $app->get('check/{countryCode}/{vatnumber}',function($countryCode,$vatnumber){
        return euvat::check($vatnumber,$countryCode);
    });  

    //gets the rate for that country
    $app->get('rate/{countryCode}/',function($countryCode){
        return ['standard_rate' => euvat::vatByCountry($countryCode)];
    });  

    //check if countryCode is european union
    $app->get('iseu/{countryCode}/',function($countryCode){
        return ['is_eu_country' => euvat::isEUcountry($countryCode)];
    });  

    //rates.json
    $app->get('rates/',function(){
        return redirect('rates.json');
    });  

    //to which country belongs this ip? how much do I need to charge him ;)
    $app->get('ip/{ipaddress}', function ($ipaddress = null, Request $request) {

        $countryCode = NULL;

        //hack to detect the clients ip...nasty
        if ($ipaddress === 'detect')
        {
            $ipaddress = $request->ip();

            //cloudflare hack saves geoip search ;)
            if (!empty($_SERVER["HTTP_CF_IPCOUNTRY"]))
                $countryCode = $_SERVER["HTTP_CF_IPCOUNTRY"];
        }

        //only if we do not have the country code
        if ($countryCode === NULL)
            $countryCode = euvat::countryCodeByIP($ipaddress);

        //we could not resolve the country for this ip...
        if ($countryCode === NULL)
            return ['result' => 'country code not found', 'ip_address' => $ipaddress ];
        else
            return  [
                    'country_code'  => $countryCode,
                    'country_name'  => euvat::countryName($countryCode),
                    'VAT'           => euvat::vatByCountry($countryCode),
                    'ip_address'    => $ipaddress
                    ];

    });



    //$app->get('product','ProductController@getProducts'); 
    //$app->get('product/{id}','ProductController@getProduct');          

});