<!--search START -->
<div
    x-data="{ isCityHelpVisible: false }"
    class="mb-4">
    <form action="" method="GET">
        <input
            name="city"
            type="search"
            value="{{ request()->get('city') }}"
            class="w-full rounded-lg px-3 py-2"
            placeholder="Search city"/>
    </form>

    <div class="m-0.5 ml-1">
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
</div>
<!--search END -->
