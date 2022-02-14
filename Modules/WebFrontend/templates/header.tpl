{% set userAccessId = user.getAccessId() %}

<div class="navigation-menu">
    {% for item in menu %}
        {% if userAccessId in item.access %}
            <div class="navigation-menu-item {{ item.class|raw }} {% if item.active %}active{% endif %}">
                <a href="{{ item.link }}" title="{{ item.entity }}">{{ item.title }}</a>
                <span class="navigation-menu-item__underline"></span>
            </div>
        {% endif %}
    {% endfor %}
</div>
