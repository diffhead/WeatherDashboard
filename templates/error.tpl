<html>
    <head>
        <title>{{ code }} Error</title>
        <link href="/styles/erorr.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="content">
            <div class="error-modal">
                <div class="error-modal-img">
                    <a href="/">
                        <img src="/images/logo.webp" alt="Site's main logotype">
                    </a>
                </div>
                <div class="error-code">{{ code }}</div>
                <div class="error-message">{{ message }}</div>
                <div class="error-additional">
                    <pre>{{ extMessage }}</pre>
                </div>
            </div>
        </div>
    </body>
</html>
