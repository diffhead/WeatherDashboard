<?php namespace Core;

use Core\Application;

use Services\DependencyInjectionService;
use Services\ApplicationService;

use Config\ApplicationConfig;
use Config\DatabaseConfig;
use Config\MemcachedConfig;

class Loader 
{
    public static function loadClass(string $className): void
    {
        $className = str_replace('\\', '/', $className);
        $classPath = _APP_BASE_DIR_ . $className . _PHP_EXTENSION_;

        if ( file_exists($classPath) ) {
            require_once($classPath);
        }
    }

    public function __construct() 
    {
        $this->initSplLoader();
        $this->initConstants();
        $this->initContext();
        $this->initConfigs();
        $this->initVendor();
    }

    public function bootstrap(): void
    {
        $context = Context::getInstance();
        $routes = ApplicationService::getCurrentRoutes();

        foreach ( $routes as $route => $instance ) {
            if ( ApplicationService::isRoute($instance) ) {
                $context->application->getRouter()->setRoute($route, $instance);
            }
        }

        if ( _ENABLE_MODULES_ ) {
            $context->application->initModules();
        }

        $context->application->run($context->applicationRequest);
    }

    private function initSplLoader(): void
    {
        spl_autoload_register('\\Core\\Loader::loadClass');
    }

    private function initConstants(): void
    {
        define('_PHP_EXTENSION_', '.php');
        define('_APP_EMPTY_STRING_', '');

        if ( php_sapi_name() === 'cli' ) {
            define('_APP_BASE_DIR_', getenv('PWD') . '/');
            define('_APP_ENVIRONMENT_', Application::CLI_ENVIRONMENT);
        } else {
            define('_APP_BASE_DIR_', $_SERVER['DOCUMENT_ROOT'] . '/');
            define('_APP_ENVIRONMENT_', Application::WEB_ENVIRONMENT);
        }
    }

    private function initContext(): void
    {
        $diContainer = DependencyInjectionService::initContainer('core.context');

        Context::setInstance(
            $diContainer->get(_APP_ENVIRONMENT_)
        );
    }

    private function initConfigs(): void
    {
        $configJson = ApplicationService::getGlobalConfigJson();

        ApplicationConfig::setFields([
            'host'    => $configJson['host'],
            'port'    => $configJson['port'],
            'dev'     => $configJson['dev'],
            'modules' => $configJson['modules']
        ]);

        DatabaseConfig::setFields([
            'driver'   => $configJson['storage']['database']['driver'],
            'host'     => $configJson['storage']['database']['host'],
            'port'     => $configJson['storage']['database']['port'],
            'username' => $configJson['storage']['database']['username'],
            'password' => $configJson['storage']['database']['password'],
            'database' => $configJson['storage']['database']['database']
        ]);

        MemcachedConfig::setFields([
            'enabled' => $configJson['storage']['memcached']['enabled'],
            'servers' => $configJson['storage']['memcached']['servers']
        ]);

        define('_ENABLE_MODULES_', ApplicationConfig::get('modules'));
        define('_DEV_MODE_',       ApplicationConfig::get('dev'));
    }

    private function initVendor(): void
    {
        require_once(_APP_BASE_DIR_ . 'vendor/autoload.php');
    }
}
