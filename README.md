# WeatherDashboard

### Project Architecture and Concepts

Project developed by simplest MVC pattern implementation
with the modules structure of the project's components. Model
and Database relation described by ActiveRecord pattern.

### Application execution looks like this:

1. Call public Loader::__contruct
 * private Loader::initSplLoader(): void
 * private Loader::initConstants(): void
 * private Loader::initContext(): void
 * private Loader::initConfigs(): void
 * private Loader::initVendor(): void
 
2. Call public Loader::bootstrap(): void
 * public Application::initModules(): bool
 * public Application::run(ApplicationRequest $request): bool
 
3. Call public Application::run(ApplicationRequest $request): bool
 * private Application::initCurrentController(ApplicationRequest $request): void
 * private Application::initCurrentUser(ApplicationRequest $request): void
 * public Controller::init(): void
 * public Controller::execute(array $params = []): bool
 * public Controller::getView(): View
 * public View::display(): void
 * public Display::echo(): void


### Application serving

If you dont have a memcached then set **memcached.enabled=false** in config.json

1. Setup nginx. Directory 'config-examples' contains nginx.conf
2. Setup ur php-fpm
3. Setup PgSQL DB
4. Execute create-tables.sql, Modules/WeatherApi/migration-postgre.sql
5. Go to app root dir and execute **composer require**
6. Go to **frontend/** dir and execute **npm install**
7. Go to **frontend/** dir and execute **npm run build-prod**
8. Make required sys dirs: log/nginx, log/cron, cache/twig, cache/file
9. Ready. Enjoy

### Application extending

According to the general concept, the developer should not touch the base files in the root directory, he needs to create a new module and work in its directory with
only by using base class calls and extending them in the module's namespace.

The great example is WebFrontend module which renders all base pages like - Index, Login, Sign Up, Admin etc.

### Application API reference

## Cli

Run **dcli** script with the following params: 

```bash
bash dcli cache-flush
OR
./dcli cache-flush
```

1. **weather-api-update** - downloads weather records from api for active cities. !!API HAVE THE COUNT RESTRICTIONS!!
2. **weather-cities-export** - exports countries and cities from the Modules\WeatherApi\worldcities.csv file
3. **cache-flush** - flushes memcached cache, file cache and DB cache

## Web - send request and get response
