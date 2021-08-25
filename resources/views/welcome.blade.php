<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favicon -->
    <link rel="icon" href="{{ asset('img/favicon.jpg') }}" type="image/jpg" sizes="32x32">
    <title>{{ str_replace('-', ' ', config('app.name')) }}</title>

    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Livewire css -->
</head>
<body class="bg-gradient-to-tr from-blue-200 to-blue-400 min-h-screen">
<div class="my-8">
    <div class="w-128 mx-auto">
        <x-searchbar />

        @if ( isset($errorMessage) )
            <div class="bg-gray-900 text-white text-lg rounded-lg overflow-hidden p-5">
                <div class="text-3xl mb-2">{{ $errorMessage['code'] }}</div>
                <div>{{ $errorMessage['message'] }}</div>
            </div>
        @endif

        @if( !empty($currentWeather) && !empty($futureWeather) )
            <x-weather-widget
                :geocoding="$geocoding"
                :currentWeather="$currentWeather"
                :hourlyWeather="$hourlyWeather"
                :futureWeather="$futureWeather"
            />
        @endif
    </div>
</div>

</div>
</body>
</html>
