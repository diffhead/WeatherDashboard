<div class="login-form">
    <div class="login-form-fields">

        {% for field in fields %}
            <input type="{{ field.type ?? 'text' }}" 
                   class="login-form-input {{ field.class ?? '' }}" 
                   data-entity="{{ field.entity ?? '' }}" 
                   placeholder="{{ field.placeholder }}"
                   {% if field.required %}required{% endif %}
            >
        {% endfor %}

    </div>
    <div class="login-form-button">

        {% for button in buttons %}
            <button class="login-form-button__item {{ button.class ?? '' }}" data-entity="{{ button.entity ?? '' }}">{{ button.title }}</button>
        {% endfor %}

        <div class="simple-spinner"></div>
    </div>
</div>
