<?php
/**
 * Project global helpers
 */

if (!function_exists('format_date')) {
    function format_date($timestamp): string
    {
        return \Carbon\Carbon::createFromTimestamp($timestamp, config('app.timezone'))->format(config('openweatherconf.date_format'));
    }
}

if (!function_exists('format_time')) {
    function format_time($timestamp): string
    {
        return \Carbon\Carbon::createFromTimestamp($timestamp, config('app.timezone'))->format(config('openweatherconf.time_format'));
    }
}

if (!function_exists('format_time_short')) {
    function format_time_short($timestamp): string
    {
        return \Carbon\Carbon::createFromTimestamp($timestamp, config('app.timezone'))->format(config('openweatherconf.time_format_short'));
    }
}

if (!function_exists('format_day')) {
    function format_day($timestamp): string
    {
        return \Carbon\Carbon::createFromTimestamp($timestamp, config('app.timezone'))->format(config('openweatherconf.day_format'));
    }
}

if (!function_exists('format_temp')) {
    function format_temp($temp): string
    {
        //units in app('units') bound in /app/Providers/AppServiceProvider.php
        return round($temp, 1) . app('units')[config('openweatherconf.units_format')]['temp']; //output: 23.7°C
    }
}

if (!function_exists('format_wind')) {
    function format_wind($speed): string
    {
        //units in app('units') bound in /app/Providers/AppServiceProvider.php
        return round($speed, 1) .' '. app('units')[config('openweatherconf.units_format')]['wind']; //output: 1.5 m/s
    }
}

if (!function_exists('get_weather_icon_url')) {
    function get_weather_icon_url($icon, $size = null): string
    {
        if (!empty($size)) {
            $size = "@{$size}x"; //output: "" or "@2x" or "@4x"
        }

        return "http://openweathermap.org/img/wn/{$icon}{$size}.png";
    }
}

if (!function_exists('get_weather_icon2x_url')) {
    function get_weather_icon2x_url($icon): string
    {
        return get_weather_icon_url($icon,2);
    }
}

if (!function_exists('get_weather_icon4x_url')) {
    function get_weather_icon4x_url($icon): string
    {
        return get_weather_icon_url($icon,4);
    }
}
