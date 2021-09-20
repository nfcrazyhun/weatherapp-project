<div
    x-data="{ isForecastVisible: true }"
    class="bg-gray-900 text-white text-sm rounded-lg overflow-hidden">
    <!-- current-weather START -->
    <div class="current-weather ">
        {{--        {{dd([$geocoding,$currentWeather,$hourlyWeather,$futureWeather])}}--}}
        <div class="flex items-center justify-around px-4 py-5">
            <div class="flex items-center">
                <div class="text-gray-400">
                    <div class="text-white text-5xl font-semibold">{{ format_temp($currentWeather['temp']) }}</div>
                    <div class="mb-0.5">Feels like: {{ format_temp($currentWeather['feels_like']) }}</div>
                    <div>Clouds: {{ $currentWeather['clouds'] }}%</div>
                    @isset($currentWeather['rain'])
                        <div>Rain: {{ $currentWeather['rain']['1h'] }} mm</div>
                    @endisset
                    @isset($currentWeather['snow'])
                        <div>Snow: {{ $currentWeather['snow']['1h'] }} mm</div>
                    @endisset
                    <div>Humidity: {{ $currentWeather['humidity'] }}%</div>
                    <div>
                        Wind: {{ format_wind($currentWeather['wind_speed']) }}
                        <img src="https://ssl.gstatic.com/m/images/weather/wind_unselected.svg"
                             class="inline" width="16" alt="icon"
                             style="transform:rotate({{ 90+$currentWeather['wind_deg'] }}deg);"
                        />
                    </div>
                    <div class="mt-0.5">UV Index: {{ round($currentWeather['uvi'],1) }}</div>
                </div>
                <div class="text-gray-400 ml-5">
                    <div
                        class="text-white text-lg font-semibold">{{ ucfirst( $currentWeather['weather'][0]['description'] ) }}</div>
                    <div class="mb-0.5">{{ $geocoding['name'] }}, {{ $geocoding['country'] }}</div>
                    <div>Sunrise: {{ format_time($currentWeather['sunrise']) }}</div>
                    <div>Sunset: {{ format_time($currentWeather['sunset']) }}</div>
                </div>
            </div>
            <div class="">
                <img src="{{ get_weather_icon4x_url($currentWeather['weather'][0]['icon']) }}" alt="icon"
                     style="height:150px">
            </div>
        </div>

        <!-- current-footer -->
        <div class="flex justify-around text-gray-300 text-xs px-4 mb-2">
            <!-- last updates -->
            <div>
                {{ format_date($currentWeather['dt']) }}, {{ format_day($currentWeather['dt']) }}
            </div>
            <div>
                Last update: {{ format_time($currentWeather['dt']) }}
            </div>

            <!-- toggle-button -->
            <button
                @click="isForecastVisible = !isForecastVisible"
                type="button"
                title="Show/Hide forecast"
                class="hover:underline"
                x-text="isForecastVisible ? 'Hide' : 'Show'"
            >
            </button>
        </div>
        <!-- current-footer -->
    </div>
    <!-- current-weather END -->


    <div
        x-show="isForecastVisible"
        class="bg-gray-800"
    >
        <div id="chart"
             class="pt-2"
             style="height:16rem;">
        </div>


        <!-- future-weather START -->
        <ul class="future-weather px-4 py-4 space-y-5 ">
            @foreach ($futureWeather as $item)
                <li class="grid grid-cols-forecast items-center">
                    <div class="text-gray-400">{{ format_day($item['dt']) }}</div>
                    <div class="flex items-center">
                        <div class="flex items-center w-7/12">
                            <div>
                                <img src="{{ get_weather_icon_url($item['weather'][0]['icon']) }}" alt="icon">
                            </div>
                            <div>
                                <div>{{ ucfirst( $item['weather'][0]['description'] ) }},</div>
                                <div class="text-yellow-300 text-sm">{{ format_temp($item['temp']['day']) }}</div>
                            </div>
                        </div>
                        <div class="flex w-5/12 text-gray-400">
                            <div>
                                <div>
                                    Rain: {{ $item['pop']*100 }}%,
                                    @isset($item['rain'])
                                        {{ round($item['rain'],1) }} mm
                                    @endisset
                                </div>
                                @isset($item['snow'])
                                    <div>Snow: {{ round($item['snow'],1) }} mm</div>
                                @endisset
                                <div>
                                    Wind: {{ format_wind($item['wind_speed']) }}
                                    <img src="https://ssl.gstatic.com/m/images/weather/wind_unselected.svg"
                                         class="inline" width="16" alt="icon"
                                         style="transform:rotate({{ 90+$item['wind_deg'] }}deg);">
                                </div>
                                <div>UV Index: {{ round($item['uvi'],1) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right text-xs">
                        <div class="text-red-300">{{ format_temp($item['temp']['max']) }}</div>
                        <div class="text-blue-300">{{ format_temp($item['temp']['min']) }}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- future-weather END -->
{{--            {{dd([$geocoding,$currentWeather,$hourlyWeather,$futureWeather])}}--}}
</div>

<!-- Charting library -->
<script src="https://unpkg.com/chart.js@2.9.4/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

<!-- Your application script -->
<script>
    const $font_color = '#ddd';
    const $grid_color = '#888';

    const chart = new Chartisan({
        el: '#chart',
        // You can also pass the data manually instead of the url:
        data: {!! $hourlyWeather !!},
        hooks: new ChartisanHooks()
            .legend({display: true, position: 'top', labels: {fontColor: $font_color}})
            // Grouped tooltips on hover:
            .tooltip({
                mode: 'index',
                intersect: false,
            })
            .colors(['#ffeb99BB', '#8eadffBB', '#aebfcfBB'])
            .borderColors(['#FFA500', '#1a73e8', '#557491'])
            .datasets([
                {type: 'line', fill: true}, //Temp
                {type: 'line', fill: true}, //PoP
                {type: 'line', fill: true}, //Wind
            ])
            .options({
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                fontColor: $font_color,
                            },
                            gridLines: {
                                color: $grid_color,
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 50,
                                fontColor: $font_color,
                            },
                            gridLines: {
                                color: $grid_color,
                            },
                        }],
                    }
                },
            })
    })
</script>
