<?php

namespace App\Services;

use App\Exceptions\WeatherException;
use Chartisan\PHP\Chartisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    private $appid;
    private $units;
    private $lang;
    private $exclude;

    /**
     * @param string $appid
     * @param string $units
     * @param string $lang
     * @param string $exclude
     */
    public function __construct(string $appid, string $units, string $lang, string $exclude)
    {
        $this->appid = $appid;
        $this->units = $units;
        $this->lang = $lang;
        $this->exclude = $exclude;
    }

    /**
     * Translate location into Geocoding location
     * https://openweathermap.org/api/geocoding-api
     *
     * @param string $location
     * @return array
     * @throws WeatherException
     */
    function getLocationGeocoding(string $location):array {
        //Cache the geocoding lookup result for a while
        $geocoding = Cache::remember($location, 86400, function () use ($location){
            return Http::get("https://api.openweathermap.org/geo/1.0/direct?q={$location}&limit=1&appid={$this->appid}")->json();
        });

        //error-check, if response is empty
        if ( empty($geocoding) ) {
            throw new WeatherException("Location not found!", 400);
        }
        //error-check, if request is not 200
        if ( isset($geocoding['cod']) && $geocoding['cod'] != 200) {
            throw new WeatherException($geocoding['message'], $geocoding['cod']);
        }

        return $geocoding[0];
    }

    /**
     * Get weather forecasts baste on latitude, longitude
     * https://openweathermap.org/current
     * https://openweathermap.org/api/one-call-api
     *
     * @param string $lat
     * @param string $lon
     * @return array
     * @throws WeatherException
     */
    function getForecast(string $lat, string $lon):array {
        //Cache the api request result for 600 sec. (Recommended) | (safe avg maximum rate: 22.81 api call/minutes)
        //Cache the response base on location
        $forecast = Cache::remember("$lat-$lon", 23, function () use ($lat, $lon) {
            return Http::get("https://api.openweathermap.org/data/2.5/onecall?lat={$lat}&lon={$lon}&appid={$this->appid}&units={$this->units}&lang={$this->lang}&exclude={$this->exclude}")->json();
        });

        //error-check, if request is not 200
        if (isset($forecast['cod']) && $forecast['cod'] != 200) {
            throw new WeatherException($forecast['message'], $forecast['cod']);
        }

        return $forecast;
    }

    /**
     * Crate Chart from hourly weather data
     * https://chartisan.dev/documentation/backend/prepare_data
     *
     * @param array $hourly
     * @return string json
     */
    function getHourlyWeatherChartData(array $hourly): string
    {
        $labels = array();
        $datasetTemp = array();
        $datasetPoP = array();
        $datasetWind = array();

        foreach ($hourly as $item) {
            array_push($labels, format_time_short($item['dt'])  );
            array_push($datasetTemp, round($item['temp'], 1) );
            array_push($datasetPoP, intval($item['pop']*100) );
            array_push($datasetWind, round($item['wind_speed'],1) );
        }

        return Chartisan::build()
            ->labels($labels)
            ->dataset('Temp', $datasetTemp)
            ->dataset('PoP', $datasetPoP)
            ->dataset('Wind', $datasetWind)
            ->toJSON();
    }
}
