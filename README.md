# Challenge API

**How to start:**
1. Run `composer install` to get external packages
2. If running locally, then execute `php -S localhost:8000`. The web root, in any case, should be in the /public directory
3. To post a score, the header `X_AUTH_TOKEN` must be present.
4. Tests should be executed from the /tests dir. For the Integration tests, the web server must be running. Bootstrap the /vender/autoload.php file. 