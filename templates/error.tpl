<html>
    <head>
        <title>{{ code }} Error</title>
        <link href="/bundle/index.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="content">
            <div class="error-modal">
                <div class="error-modal-menu">
                    <button>Home</button>
                    <button>Expand</button>
                    <button>ShortIt</button>
                </div>
                <div class="error-modal-img error-row">
                    <a href="/">
                        <div class="error-modal-img__a">
                            <img src="/images/logo.webp" alt="Site's main logotype">
                            <span>Go to homepage</span>
                        </div>
                    </a>
                </div>
                <div class="error-modal-code error-row">{{ code }}</div>
                <div class="error-modal-message error-row">{{ message }}</div>
                
                {% if extMessage and extMessage != '' %}
                    <div class="error-modal-additional error-row">
                        <pre>{{ extMessage }}</pre>
                    </div>
                {% endif %}
            </div>
        </div>
    </body>
</html>
