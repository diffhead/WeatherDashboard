<div class="auth-form">
    <div class="auth-form-fields">

        {% for field in fields %}
            <input type="{{ field.type ?? 'text' }}" 
                   class="auth-form-input {{ field.class ?? '' }}" 
                   data-entity="{{ field.entity ?? '' }}" 
                   placeholder="{{ field.placeholder }}"
                   {% if field.required %}required{% endif %}
            >
        {% endfor %}

    </div>
    <div class="auth-form-button">

        {% for button in buttons %}
            <button class="auth-form-button__item {{ button.class ?? '' }}" data-entity="{{ button.entity ?? '' }}">{{ button.title }}</button>
        {% endfor %}

        <div class="simple-spinner"></div>
    </div>
</div>
