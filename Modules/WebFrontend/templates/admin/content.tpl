{% if error %}
    <h1>{{ error }}</h1>
{% else %}
    <div class="tabbed-content">
        <div class="tabs">
            <div class="tab active" data-entity="modules">Modules</div>
            <div class="tab" data-entity="users">Users</div>
            <div class="tab" data-entity="weather-api">Weather API</div>
        </div>
        <div class="contents">
            <div class="content active" data-entity="modules">
                {% include 'admin/modules.tpl' %}
            </div>

            <div class="content" data-entity="users">
                {% include 'admin/users.tpl' %}
            </div>

            <div class="content" data-entity="weather-api">
                {% include 'admin/weather.tpl' %}
            </div>
        </div>
    </div>
{% endif %}
