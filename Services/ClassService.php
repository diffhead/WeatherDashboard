<?php namespace Services;

class ClassService
{
    public static function propertyExists(string|object $class, string $property): bool
    {
        return property_exists($class, $property);
    }

    public static function methodExists(string|object $class, string $method): bool
    {
        return method_exists($class, $method);
    }
}
