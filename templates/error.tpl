{% if entity == '1' %}
    <h1>Error {{ code }}</h1>
    <h3>{{ message }}</h3>
{% else %}
    {{ code }} {{ message }}
{% endif %}
