<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('FundingOpportunityType/create/', function(){

    return view('FundingOpportunities.createType');
});

/*Route::post('/create/FundingOpportunityType', function(){
   return "success";
});*/

Route::get('/FundingOpportunityType', 'FundingOpportunityTypeController@index');
Route::post('/FundingOpportunityType', 'FundingOpportunityTypeController@store');
Route::delete('/FundingOpportunityType', 'FundingOpportunityTypeController@delete');
#Come back and learn how to do Delete etc... ^6