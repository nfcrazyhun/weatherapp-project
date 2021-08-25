<?php

return [

    /**
     * Get a free Open Weather Map API key : https://openweathermap.org/price.
     */

    'api_key' => env('OPENWEATHER_API_KEY',''),


    /**
     * Multilingual support
     *
     * You can use the lang parameter to get the output in your language.
     * Translation is applied for the city name and description fields.
     * https://openweathermap.org/current#multi
     */

    'lang' => env('OPENWEATHER_API_LANG','en'),


    /**
     * Date and Time formats.
     *
     * https://www.php.net/manual/en/datetime.format.php
     */
    'date_format' => env('OPENWEATHER_API_DATE_FORMAT','Y-m-d'),
    'time_format' => env('OPENWEATHER_API_TIME_FORMAT','H:i:s'),
    'time_format_short' => env('OPENWEATHER_API_TIME_FORMAT_SHORT','H:i'),
    'day_format' => env('OPENWEATHER_API_DAY_FORMAT','l'),


    /**
     * Units of measurement
     *
     * Temperature in Kelvin and wind speed in meter/sec is used by default, units=standard
     * For temperature in Celsius and wind speed in meter/sec, use units=metric
     * For temperature in Fahrenheit and wind speed in miles/hour, use units=imperial
     * https://openweathermap.org/current#data
     */

    'units_format' => env('OPENWEATHER_API_UNITS_FORMAT','metric'),
];
