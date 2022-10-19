<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Location;
use App\Models\WeatherData;
use App\Models\WeatherType;
use Carbon\Carbon;

class FetchWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yr:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $params = [
            'headers' => [
                'Content-Type' =>  'application/json',
                'User-Agent'   => 'GetLocationWeatherData/1.0',
                'From'         => 'mr.amersharif@gmail.com',
            ],
        ];
        $locations = Location::all();
        
        foreach($locations as $location){
            try {
                $url = "https://api.met.no/weatherapi/locationforecast/2.0/compact?lat=".$location->latitude."&lon=".$location->longitude;
                $data = $client->request('GET', $url, $params);
            } catch (RequestException $ex) {
                // Todo: check if we should use something else. Does abort stop the loop?
                abort(404, 'Weather data not found');
            }
            
            $data = json_decode($data->getBody());
            $timeseries = $data->properties->timeseries;
            $period_start =     Carbon::parse($timeseries[0]->time);
            $precipitation =    intval(round($timeseries[0]->data->next_6_hours->details->precipitation_amount));
            $icon =             $timeseries[0]->data->next_6_hours->summary->symbol_code;
            $temperature = [];

            foreach($timeseries as $serie){
                $temperature[] = $serie->data->instant->details->air_temperature;

                if(count($temperature) >= 6){
                    break;
                } 
            }

            $temperature = intval(round(array_sum($temperature) / count($temperature)));
            break;
            WeatherData::create([
                'location_id' => $location->id,
                'period_start' => $period_start,
                'weather_type_id' => 1,
                'temperature' => $temperature,
                'precipitation' => $precipitation 
            ]);
        }

    }
}
