<?php namespace Core\Log;

use Interfaces\Logger;
use Interfaces\LoggerStatic;

class ApplicationLogger implements LoggerStatic
{
    private static ?Logger $instance = null;

    public static function getInstance(): Logger
    {
        if ( self::$instance === null ) {
            self::$instance = new FileLog(
                _APP_BASE_DIR_ . 'log/application_' . date('dmY') . '.log', E_ALL
            );
        }

        return self::$instance;
    }

    public static function log(string $message, int $level = E_NOTICE): bool
    {
        return self::getInstance()->log($message, $level);
    }

    public static function notice(string $message): bool
    {
        return self::getInstance()->notice($message);
    }

    public static function warning(string $message): bool
    {
        return self::getInstance()->warning($message);
    }

    public static function error(string $message): bool
    {
        return self::getInstance()->error($message);
    }
}
