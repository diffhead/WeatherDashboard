<?php namespace Core;

use Interfaces\Module;

class ModulesRegistry
{
    private static array $_INSTANCES = [];

    public static function setModule(string $name, Module $instance): void
    {
        self::$_INSTANCES[$name] = $instance;
    }

    public static function getModule(string $name): null|Module
    {
        if ( isset(self::$_INSTANCES[$name]) === false ) {
            return null;
        }

        return self::$_INSTANCES[$name];
    }
}
