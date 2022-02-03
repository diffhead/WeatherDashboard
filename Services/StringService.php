<?php namespace Services;

class StringService
{
    public static function isString(mixed $value): bool
    {
        return is_string($value);
    }

    public static function isEmpty(string $string): bool
    {
        return empty($string);
    }

    public static function concat(): string
    {
        $args = func_get_args();
        $string = '';

        foreach ( $args as $arg ) {
            if ( self::isString($arg) ) {
                $string .= $arg;
            }
        }

        return $string;
    }

    public static function trim(string $string): string
    {
        return trim($string);
    }

    public static function toLowerCase(string $string): string
    {
        return strtolower($string);
    }

    public static function toUpperCase(string $string): string
    {
        return strtoupper($string);
    }

    public static function strPosition(string $string, string $pattern, int $offset = 0): int
    {
        $strpos = strpos($string, $pattern, $offset);

        if ( $strpos === false ) {
            return -1;
        }

        return $strpos;
    }

    public static function strReplace(string $string, string $pattern, string $replacement): string
    {
        return str_replace($pattern, $replacement, $string);
    }

    public static function subString(string $string, int $offset = 0, null|int $length = null): string
    {
        return substr($string, $offset, $length);
    }

    public static function explode(string $string, string $delimiter = PHP_EOL): array
    {
        return explode($delimiter, $string);
    }
}
