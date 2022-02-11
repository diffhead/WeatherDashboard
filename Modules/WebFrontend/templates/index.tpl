<html>
<head>
    <title>{{ title }}</title>
</head>
<body>
    <div class="application">
        <div class="items">
            {% for module in modules %}
                <div class="module">
                    <div class="module-id">{{ module.id }}</div>
                    <div class="module-name">{{ module.name }}</div>
                    <div class="module-enabled">{{ module.enabled }}</div>
                </div>
            {% endfor %}
        </div>
    </div>
</body>
</html>
