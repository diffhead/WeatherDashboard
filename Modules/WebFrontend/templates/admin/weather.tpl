{% if weather and weather.api %}
    {% set key = weather.api.key ? weather.api.key : '' %}
    {% set uri = weather.api.uri ? weather.api.uri : '' %}
    {% set cities = weather.api.cities ? weather.api.cities: [] %}
    {% set countries = weather.api.countries ? weather.api.countries : [] %}
{% else %}
    {% set key = '' %}
    {% set uri = '' %}
    {% set cities = [] %}
    {% set countries = [] %}
{% endif %}

<div class="weather-settings">
    <div class="weather-settings__api">
        <div class="weather-settings__api--key">
            <input name="apikey" class="weather-settings__api--key-input" value="{{ key }}">
        </div>

        <div class="weather-settings__api--uri">
            <input name="apiuri" class="weather-settings__api--uri-input" value="{{ uri }}">
        </div>

        <div class="weather-settings__api--save">
            <button class="weather-settings__api--save-button">Save API</button>
        </div>

        <div class="weather-settings__api--location">
            <div class="weather-coords">
                <div class="weather-coords-input">
                    {% include 'select-with-input.tpl' with { 
                        select: { 
                            id: 'weatherCountrySelect', 
                            options: countries, 
                            selected: countries[0],
                            class: 'country-select'
                        } 
                    } %}

                    {% include 'select-with-input.tpl' with { 
                        select: { 
                            id: 'weatherCitySelect', 
                            options: cities,
                            class: 'city-select'
                        } 
                    } %}
                </div>
                <div class="weather-coords-latlon">
                    <div class="weather-coords-latlon--lat">
                        <div class="weather-coords-latlon--label">Latitude: </div>
                        <input name="latitude" class="weather-coords-latlon--input">
                    </div>

                    <div class="weather-coords-latlon--lon">
                        <div class="weather-coords-latlon--label">Longitude: </div>
                        <input name="longitude" class="weather-coords-latlon--input">
                    </div>
                </div>
            </div>

            <div class="weather-coords--controls">
                <button class="weather-coords-save--button">Save City</button>
            </div>
        </div>
    </div>
</div>
