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
Route::get('/user', function( Request $request ){
    return $request->user();
});

/**
 * | TODO:           change to it's own controller when ready
 * | URL:            /api/locations
 * | Controller:     API\WeatherDataController@getAllLocations
 * | Method:         GET
 * | Description:    Gets all locations
 */
Route::get('/locations', 'App\Http\Controllers\WeatherDataController@getAllLocations');

/**
 * | URL:            /api/locationweather
 * | Controller:     API\WeatherDataController@getAllLocationsWeather
 * | Method:         GET
 * | Description:    Gets weather for all locations
 */
Route::get('/locationweather', 'App\Http\Controllers\WeatherDataController@getAllLocationsWeather');

/**
 * | URL:            /api/locationweather/{latitude}/{longitude}
 * | Controller:     API\WeatherDataController@getLocationWeather
 * | Method:         GET
 * | Description:    Gets weather for an individual location
 */
Route::get('/locationweather/{latitude}/{longitude}', 'App\Http\Controllers\WeatherDataController@getLocationWeather');

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact support'], 404);
});