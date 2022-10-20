<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function(){
    Route::get('/user', function( Request $request ){
      return $request->user();
    });

    /*
    |-------------------------------------------------------------------------------
    | Get All 
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/LocationWeather
    | Controller:     API\LocationWeatherController@getLocationWeather
    | Method:         GET
    | Description:    Gets weather for all locations
    */
    Route::get('/locationweather', 'API\LocationWeatherController@getLocationWeather');

    /*
    |-------------------------------------------------------------------------------
    | Get weather for an individual location
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/LocationWeather/{id}
    | Controller:     API\LocationWeatherController@getLocationWeather
    | Method:         GET
    | Description:    Gets weather for an individual location
    */
    Route::get('/locationweather/{id}', 'API\LocationWeatherController@getCafe');
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact support'], 404);
});