<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WeatherData;
use Illuminate\Http\Request;
use App\Models\Location;

class WeatherDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeatherData  $weatherData
     * @return \Illuminate\Http\Response
     */
    public function show(WeatherData $weatherData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WeatherData  $weatherData
     * @return \Illuminate\Http\Response
     */
    public function edit(WeatherData $weatherData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeatherData  $weatherData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeatherData $weatherData)
    {
        //
    }

    /**
     * |-------------------------------------------------------------------------------
     * | Get all locations
     * | TODO: Move this to it's own contoller
     * |-------------------------------------------------------------------------------
     * | URL:            /api/v1/locations
     * | Method:         GET
     * | Description:    Gets locationinfo for all stations in database
     */
    public function getAllLocations()
    {
        $locations = Location::all();

        return response()->json( $locations );
    }

    /**
     * |-------------------------------------------------------------------------------
     * | Get weather for all locations
     * |-------------------------------------------------------------------------------
     * | URL:            /api/v1/locationweather
     * | Method:         GET
     * | Description:    Gets weather data for all the locations in database
     */
    public function getAllLocationsWeather()
    {
        $locationData = Location::join('weather_data', 'locations.id', '=', 'weather_data.location_id')
                        ->select(   'locations.name', 
                                    'weather_data.weather_type_id', 
                                    'weather_data.temperature', 
                                    'weather_data.precipitation')
                        ->get();
        return response()->json( $locationData );
    }

    /**
     * |-------------------------------------------------------------------------------
     * | Get weather data for an invidual location
     * |-------------------------------------------------------------------------------
     * | URL:            /api/v1/locationweather/{latitude}/{longitude}
     * | Method:         GET
     * | Description:    Gets weather data for an invidual location
     * | Parameters:
     * |   $latitude   -> latitude position for location
     * |   $longitude  -> longitude position for location
     * 
     */
    public function getLocationWeather($latitude, $longitude)
    {
        $locationData = Location::join('weather_data', 'locations.id', '=', 'weather_data.location_id')
                        ->select(   'locations.name', 
                                    'weather_data.weather_type_id', 
                                    'weather_data.temperature', 
                                    'weather_data.precipitation')
                        ->where('locations.latitude', '=', $latitude)
                        ->where('locations.longitude', '=', $longitude)
                        ->get();
        return response()->json( $locationData );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeatherData  $weatherData
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeatherData $weatherData)
    {
        //
    }
}
