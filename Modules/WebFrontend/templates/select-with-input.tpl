{% if select.selected %}
    {% set selectedId = select.selected.id %}
    {% set selectedTitle = select.selected.title %}
    {% set selectedValue = select.selected.value %}
    {% set selectedSelected = 1 %}
{% else %}
    {% set selectedId = '' %}
    {% set selectedTitle = '' %}
    {% set selectedValue = '' %}
    {% set selectedSelected = '' %}
{% endif %}

{% if select.placeholder %}
    {% set selectPlaceholder = select.placeholder %}
{% else %}
    {% set selectPlaceholder = 'No selected' %}
{% endif %}

{% set class = '' %}
{% if select.class %}
    {% set class = select.class %}
{% endif %}

<div class="cselect-with-input {{ class }}" id="{{ select.id }}"

     data-id="{{ selectedId }}"
     data-title="{{ selectedTitle }}"
     data-value="{{ selectedValue }}"
     data-selected="{{ selectedSelected }}"
>
    <div class="cselect-with-input--input">
        <input data-searchbar value="">
    </div>
    <div class="cselect-with-input--value {% if selectedId == '' %}hidden{% endif %}">
        <span>{{ selectedTitle }}</span>
    </div>
    <div class="cselect-with-input--placeholder {% if selectedId != '' %}hidden{% endif %}">
        <span>{{ selectPlaceholder }}</span>
    </div>
    <div class="cselect-with-input--select">
        {% for option in select.options %}
            <div class="cselect-select--option{% if option.id == selectedId %} selected{% endif %}" 

                 data-id="{{ option.id }}"
                 data-title="{{ option.title }}"
                 data-value="{{ option.value }}"
                 data-selected="{{ option.selected ? 1 : 0 }}"
            >
                <span>{{ option.title }}</span>
            </div>
        {% endfor %}
    </div>
    <div class="cselect-with-input--toggle">
        <span class="cselect-with-input--toggle-open"></span>
        <span class="cselect-with-input--toggle-close"></span>
    </div>
</div>
