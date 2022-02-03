<?php namespace Core;

use Interfaces\Configuration;

use Services\ClassService;
use Services\StringService;

class RuntimeConfig implements Configuration
{
    protected static function getCurrentClass(): string
    {
        static $class = '';

        if ( StringService::isEmpty($class) ) {
            $class = get_called_class();
        }

        return $class;
    }

    public static function setFields(array $fields): bool
    {
        $isOk = true;

        foreach ( $fields as $name => $value ) {
            $isOk &= self::set($name, $value);
        }

        return $isOk;
    }

    public static function set(string $code, mixed $value): bool
    {
        if ( ClassService::propertyExists(static::getCurrentClass(), $code) === false ) {
            return false;
        }

        static::$$code = $value;

        return true;
    }

    public static function get(string $code): mixed
    {
        if ( ClassService::propertyExists(static::getCurrentClass(), $code) === false ) {
            return null;
        }

        return static::$$code;
    }
}
