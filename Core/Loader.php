<?php namespace Core;

use Core\DependencyInjection\Container;

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
        $context = Context::getInstance();

        if ( _ENABLE_MODULES_ ) {
            $context->application->initModules();
        }

        $context->application->run($context->applicationRequest);
    }

    private function initConstants(): void
    {
        define('_APP_BASE_DIR_', $_SERVER['DOCUMENT_ROOT'] . '/');
        define('_PHP_EXTENSION_', '.php');
        define('_DEV_MODE_', true);
        define('_ENABLE_MODULES_', true);

        if ( !empty($_SERVER['HTTP_HOST']) ) {
            define('_APP_ENVIRONMENT_', Application::WEB_ENVIRONMENT);
        } else {
            define('_APP_ENVIRONMENT_', Application::CLI_ENVIRONMENT);
        }
    }

    private function initSplLoader(): void
    {
        spl_autoload_register('\\Core\\Loader::loadClass');
    }

    private function initContext(): void
    {
        $diContainer = new Container('context');

        Context::setInstance(
            $diContainer->get(_APP_ENVIRONMENT_)
        );
    }
}
