<?php namespace Services;

use Exception;

use Interfaces\Controller;

use Core\Route;
use Core\Application;
use Core\FileStream;

use Factories\Web\HttpHeaderFactory;
use Factories\Web\HttpCookieFactory;

use Services\MockService;

class ApplicationService
{
    public static function getGlobalConfigJson(): array
    {
        static $configJson;

        if ( isset($configJson) === false ) {
            $configFile = new FileStream(_APP_BASE_DIR_ . 'config.json');

            if ( $configFile->open() === false ) {
                throw new Exception("Application config reading error.");
            }

            $configText = $configFile->read();
            $configJson = JsonService::decode($configText);

            if ( JsonService::lastError() !== JSON_ERROR_NONE ) {
                throw new Exception("Application config decoding error: " . JsonService::lastError());
            }
        }

        return $configJson;
    }

    public static function isRoute(mixed $isRoute): bool
    {
        return $isRoute instanceof Route;
    }

    public static function getCurrentRoute(): string
    {
        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            return $_SERVER['REQUEST_URI'];
        } else {
            return $argv[1];
        }
    }

    public static function getCurrentMethod(): string
    {
        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            return $_SERVER['REQUEST_METHOD'];
        }

        return _APP_EMPTY_STRING_;
    }

    public static function getCurrentHeaders(): array
    {
        $headers = [];

        $currentHeaders = getallheaders();

        foreach ( $currentHeaders as $name => $value ) {
            $lowCaseName = StringService::toLowerCase($name);

            $headers[] = HttpHeaderFactory::get($lowCaseName, $value);
        }

        return $headers;
    }

    public static function getCurrentCookies(): array
    {
        $cookies = [];

        foreach ( $_COOKIE as $name => $value ) {
            $cookies[] = HttpCookieFactory::get($name, $value);
        }

        return $cookies;
    }

    public static function getCurrentData(): array
    {
        $dataContainer = [];

        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            $phpInputStream = new FileStream('php://input');

            if ( $phpInputStream->open() ) {
                $inputText = $phpInputStream->read();
                $inputJson = JsonService::decode($inputText);

                if ( JsonService::lastError() === JSON_ERROR_NONE ) {
                    $dataContainer = ArrayService::merge($dataContainer, $inputJson);
                }
            }

            $dataContainer = ArrayService::merge($dataContainer, $_POST, $_GET);
        } else {
            $dataContainer = ArrayService::slice($argv, 2);
        }

        return $dataContainer;
    }

    public static function isController(mixed $isController): bool
    {
        return $isController instanceof Controller;
    }
}
