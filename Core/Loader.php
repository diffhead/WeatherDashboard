<?php namespace Core;

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
    }

    public function bootstrap(): void
    {
        /*
        $context = Context::getInstance();

        if ( _ENABLE_MODULES_ ) {
            $context->application->initModules();
        }

        $context->application->run($context->applicationRequest);
        */
    }

    private function initConstants(): void
    {
        define('_PHP_EXTENSION_', '.php');

        if ( php_sapi_name() === 'cli' ) {
            define('_APP_BASE_DIR_', getenv('PWD') . '/');
            //define('_APP_ENVIRONMENT_', Application::CLI_ENVIRONMENT);
        } else {
            define('_APP_BASE_DIR_', $_SERVER['DOCUMENT_ROOT'] . '/');
            //define('_APP_ENVIRONMENT_', Application::WEB_ENVIRONMENT);
        }

        define('_APP_ENVIRONMENT_', 'web');

        define('_DEV_MODE_', true);
        define('_ENABLE_MODULES_', true);
    }

    private function initSplLoader(): void
    {
        spl_autoload_register('\\Core\\Loader::loadClass');
    }

    private function initContext(): void
    {
    }
}
