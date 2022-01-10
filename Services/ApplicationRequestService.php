<?php namespace Services;

use Factories\Web\HttpHeaderFactory;

use Core\Application;

class ApplicationRequestService
{
    public static function getRequestRoute(): string
    {
        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            return $_SERVER['REQUEST_URI'];
        } else {
            return $_SERVER['argv'][0];
        }
    }

    public static function getRequestData(): array
    {
        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            // TODO: to create FileStream class
            $inputData = file_get_contents('php://input');
            $jsonData = JsonService::decode($inputData);

            if ( JsonService::lastError() !== JSON_ERROR_NONE ) {
                // TODO: Log it after the Logger class creation
                $jsonData = [];
            }

            if ( ArrayService::isArray($jsonData) === false ) {
                $jsonData = [ $jsonData ];
            }

            return ArrayService::merge($jsonData, $_GET, $_POST);
        } else {
            return ArrayService::slice($_SERVER['argv'], 1);
        }
    }

    public static function getRequestMethod(): string
    {
        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            return $_SERVER['REQUEST_METHOD'];
        }

        return '';
    }

    public static function getRequestHeaders(): array
    {
        $headersArray = [];

        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            $headers = getallheaders();

            foreach ( $headers as $header => $value ) {
                $headersArray[] = HttpHeaderFactory::get($header, $value, true);
            }
        }

        return $headersArray;
    }

    public static function getRequestCookies(): array
    {
        $cookiesArray = [];

        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            // #TODO
        }

        return $cookiesArray;
    }
}
