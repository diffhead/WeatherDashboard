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
                <div class="module-items">

                    <div class="module-item">
                        <div class="module-item__name">Имя модуля</div>
                        <div class="module-item__enable">Вкл.</div>
                        <div class="module-item__environment">Окружение</div>
                        <div class="module-item__priority">Приоритет</div>
                    </div>

                {% for module in modules %}
                    <div class="module-item" data-module="{{ module.name }}" 
                                             data-enable="{{ module.enable }}" 
                                             data-environment="{{ module.environment }}"
                                             data-id="{{ module.id }}"
                    >
                        <div class="module-item__name">{{ module.name }}</div>
                        <div class="module-item__enable">
                            <input class="module-item__enable-input" type="checkbox" title="Enabled" {% if module.enable %}checked{% endif %}>
                        </div>
                        <div class="module-item__environment">{{ module.environment }}</div>
                        <div class="module-item__priority">{{ module.priority }}</div>
                        <div class="module-item__controls">
                            <button class="module-item__controls--button-edit" data-active="true">Изменить</button>
                            <button class="module-item__controls--button-save" data-active="false">Сохранить</button>
                            <button class="module-item__controls--button-delete">Удалить</button>
                        </div>
                    </div>
                {% endfor %}

                    <div class="module-item">
                        <div class="module-item__name">
                            <input name="name">
                        </div>
                        <div class="module-item__enable">
                            <input name="enable" type="checkbox" checked>
                        </div>
                        <div class="module-item__environment">
                            <select name="environment">
                                <option value="web">Web</option>
                                <option value="cli">Cli</option>
                            </select>
                        </div>
                        <div class="module-item__priority">
                            <input name="priority" type="number" value="10">
                        </div>
                        <div class="module-item__controls">
                            <button class="module-item__controls--button-create">Добавить</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="content" data-entity="users">
            </div>

            <div class="content" data-entity="weather-api">
            </div>
        </div>
    </div>
{% endif %}
