<div class="module-items">
    <div class="module-item decoration" data-id="head">
        <div class="module-item__name">Name</div>
        <div class="module-item__enable">Enabled</div>
        <div class="module-item__environment">Environment</div>
        <div class="module-item__priority">Priority</div>
    </div>

    {% for module in modules %}
    <div class="module-item" data-name="{{ module.name }}" 
                             data-enable="{{ module.enable ? 1 : 0 }}" 
                             data-environment="{{ module.environment }}"
                             data-priority="{{ module.priority }}"
                             data-id="{{ module.id }}"
    >
        <div class="module-item__name">
            <span>{{ module.name }}</span>
            <input name="name" value="{{ module.name }}" disabled>
        </div>
        <div class="module-item__enable">
            <input class="module-item__enable-input" name="enable" type="checkbox" title="Enabled" {% if module.enable %}checked{% endif %} disabled>
        </div>
        <div class="module-item__environment">
            <span>{{ module.environment }}</span>
            <select name="environment">
                <option value="web">Web</option>
                <option value="cli">Cli</option>
            </select>
        </div>
        <div class="module-item__priority">
            <span>{{ module.priority }}</span>
            <input name="priority" type="number" value="{{ module.priority }}">
        </div>
        <div class="module-item__controls">
            <button class="module-item__controls--button-edit" data-entity="edit">Edit</button>
            <button class="module-item__controls--button-save" data-entity="save">Save</button>
            <button class="module-item__controls--button-delete">Delete</button>
        </div>
    </div>
    {% endfor %}

    <div class="module-item decoration" data-id="NULL" data-name="" data-environment="web" data-priority="10" data-enable="1">
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
            <button class="module-item__controls--button-create">Create</button>
        </div>
    </div>
</div>

