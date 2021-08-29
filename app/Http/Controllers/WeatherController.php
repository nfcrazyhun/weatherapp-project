<?php

namespace App\Http\Controllers;

use App\Exceptions\WeatherException;
use App\Services\WeatherService;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    /**
     * Single Action Weather Controllers
     *
     //* @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        /**
         * OpenWeatherMap API Free plan limitations (2021-08-01):
         * Globally:
         *   - 60 calls/minute
         *   - 1,000,000 calls/month
         *
         * OneCall:
         *   - 1,000 calls/day
         *   - 30,000 calls/month
         */

        //Parameters
        $location = request('city') ?? "Pécs,HU"; //Null Coalescing Operator '??'

        $appid = config('openweatherconf.api_key');
        $units = config('openweatherconf.units_format');
        $lang = config('openweatherconf.lang');
        $exclude = "minutely,alerts";


        //instantiate WeatherService
        $weatherService = new WeatherService($appid,$units,$lang,$exclude);

        try {
            $geocoding = $weatherService->getLocationGeocoding($location);

            // if lat-lon not empty in querystring use then, else get them from geocoding
            $lat = request('lat') ?? $geocoding['lat'];
            $lon = request('lon') ?? $geocoding['lon'];

            $forecast = $weatherService->getForecast($lat, $lon);

        } catch (WeatherException $e) {
            return view('welcome')->with([
                'errorMessage' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ]
            ]);
        }

        $hourlyWeather = $weatherService->getHourlyWeatherChartData($forecast['hourly']);

        return view('welcome')->with([
            'geocoding' => $geocoding,
            'currentWeather' => $forecast['current'],
            'hourlyWeather' => $hourlyWeather,
            'futureWeather' => $forecast['daily'],
        ]);
    }
}
