<?php namespace Services;

class HelperService
{
    public static function isNull(mixed $isNull): bool
    {
        return is_null($isNull);
    }

    public static function isBool(mixed $isBool): bool
    {
        return is_bool($isBool);
    }
}
