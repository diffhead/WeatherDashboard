{% if weather and weather.api %}
    {% set key = weather.api.key ? weather.api.key : '' %}
    {% set uri = weather.api.uri ? weather.api.uri : '' %}
{% else %}
    {% set key = '' %}
    {% set uri = '' %}
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
    </div>
</div>
