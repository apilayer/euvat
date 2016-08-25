<?php
use App\euvat;
use App\emailvalidator;
use Illuminate\Http\Request;
use Rinvex\Country\Models\Country;

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
});


$app->group(['prefix' => 'api','namespace' => 'Http\Controllers'], function($app)
{
    
    //full info for that company
    $app->get('info/{vatnumber}',function($vatnumber){
        return euvat::companyInfo($vatnumber);
    });  

    //just tell me if the company is EU
    $app->get('validate/{vatnumber}',function($vatnumber){
        return euvat::validate($vatnumber);
    });  

    //gets the rate for that country
    $app->get('rate/{countryCode}/',function($countryCode){
        return ['vat' => euvat::vatByCountry($countryCode)];
    }); 

     //gets the rate for that country
    $app->get('calc/{countryCode}/{amount}/',function($countryCode,$amount){
        return euvat::calc($countryCode,$amount);
    });  

    //check if countryCode is european union
    $app->get('iseu/{countryCode}/',function($countryCode){
        return euvat::isEUcountry($countryCode);
    });  

    //rates.json
    $app->get('rates/',function(){
        return redirect('rates.json');
    });  

    //to which country belongs this ip? how much do I need to charge him ;)
    $app->get('ip/{ipaddress}', function ($ipaddress, Request $request) {
        return euvat::countryCodeByIP($ipaddress,$request);
    });

    //returns country information
    $app->get('country/{countryCode}',function($countryCode){
        $countryInfo = (new Country)->find(strtoupper($countryCode));
        return ($countryInfo!==NULL)?$countryInfo:['result'=>'Country code not found '.$countryCode];
    });  

});