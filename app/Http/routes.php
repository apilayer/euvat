<?php
//use App;
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


$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function($app)
{
    $app->get('info/{countrycode}/{vatnumber}',function($countrycode,$vatnumber){
        //return App\euvat::get_vat_rates();
        return App\euvat::companyInfo($vatnumber,$countrycode);
    });  

    $app->get('check/{countrycode}/{vatnumber}',function($countrycode,$vatnumber){
        //return App\euvat::get_vat_rates();
        return App\euvat::check($vatnumber,$countrycode);
    });  

    $app->get('rate/{countrycode}/',function($countrycode){
        return ['standard_rate'=>App\euvat::vat_by_country($countrycode)];
    });  

    $app->get('iseu/{countrycode}/',function($countrycode){
        return ['is_eu_country'=>App\euvat::is_eu_country($countrycode)];
    });  

    //rates.json
    $app->get('rates/',function(){
        return redirect('rates.json');
    });  



    //$app->get('product','ProductController@getProducts'); 
    //$app->get('product/{id}','ProductController@getProduct');          

});