<?php namespace Services;

class HelperService
{
    public static function isNull(mixed $isNull): bool
    {
        return is_null($isNull);
    }

    public static function methodExists(Object|string $objectOrClassName, string $methodName): bool
    {
        return method_exists($objectOrClassName, $methodName);
    }

    public static function getClass(Object $object): string
    {
        return get_class($object);
    }

    public static function isSet(mixed $value): bool
    {
        return isset($value);
    }

    public static function isEmpty(mixed $value): bool
    {
        return empty($value);
    }
}
