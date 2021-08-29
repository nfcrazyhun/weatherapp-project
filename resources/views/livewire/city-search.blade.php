<div class="mb-4">
<!--search START -->
    <div
        x-data="{ isResultsVisible: false }"
    >
        <input
            @click="isResultsVisible = true"
            @click.away="isResultsVisible = false"
            wire:model="city"
            id="city"
            class="w-full rounded-lg px-3 py-2"
            type="search"
            placeholder="Search city..."
            autocomplete="off"
        />

        @if ( strlen($city) > 2 )
            <ul
                x-show="isResultsVisible"
                x-transition
                x-cloak
                class="absolute z-50 bg-white border border-gray-300 w-96 rounded-md mt-2 text-gray-700 text-sm divide-y divide-gray-200">
                @forelse ($searchResults as $result)
                    <li>
                        <a
                            href="{{ route('welcome', [
                                        'city' => $result['name'] . ',' . $result['sys']['country'],
                                        'lat' => $result['coord']['lat'],
                                        'lon' => $result['coord']['lon'],
                                    ]) }}"
                            class="flex items-center justify-around hover:bg-gray-200 transition ease-in-out duration-150"
                        >
                            <!-- name -->
                            <div class="font-semibold">
                                {{ $result['name']}}, {{$result['sys']['country'] }}
                            </div>

                            <!-- temp -->
                            <div>{{ format_temp($result['main']['temp']-273.15) }}</div>

                            <!-- icon -->
                            <img src="{{ get_weather_icon_url($result['weather'][0]['icon']) }}" alt="icon">

                            <!-- coords -->
                            <div class="text-gray-400 text-xs">
                                {{ number_format($result['coord']['lat'],3) }},
                                {{ number_format($result['coord']['lon'],3) }}
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="p-4">No results found for "{{ $city }}"</li>
                @endforelse
            </ul>
        @endif

    </div>

    <div
        x-data="{ isCityHelpVisible: false }"
        class="m-0.5 ml-1"
    >
        <button
            @click="isCityHelpVisible = !isCityHelpVisible"
            type="button"
            title="Show/Hide help"
            class="text-sm font-semibold hover:underline"
        >
            Did not find the correct city?
        </button>
        <div
            x-show="isCityHelpVisible"
            x-transition
            x-cloak
            class="bg-gray-100 text-sm font-semibold rounded-lg px-3 py-2"
        >
            <div>Try narrow the search:</div>
            <div class="text-base mb-0.5" style="color:#EB6E4B;">{city name},{state code},{country code}</div>
            <div class="">e.g.:</div>
            <ul class="list-disc pl-6">
                <li>London,gb</li>
                <li>London,oh,us</li>
            </ul>
            <div class="italic text-gray-600 font-normal mt-0.5">
                City name, state code (only for the US) and country code divided by comma. Please use ISO 3166 country codes.
            </div>
        </div>
    </div>
<!--search END -->
</div>
