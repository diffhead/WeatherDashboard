{% set contentTemplate = './' ~ entity %}
{% set contentTemplate = contentTemplate ~ '/content.tpl' %}

<html>
    <head>
        <title>{{ title }}</title>
        <link href="/bundle/index.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="header">
            {% include 'header.tpl' %}
        </div>
        <div class="content margin-from-header">
            {% include contentTemplate %}
        </div>
        <div class="footer">
            {% include 'footer.tpl' %}
        </div>
        <script src="/bundle/index.js"></script>
    </body>
</html>
