<?php namespace Services;

class TestService
{
    public static function getBoolTrue(): bool
    {
        return true;
    }

    public static function getGreetings(string $greetings): string
    {
        return $greetings;
    }
}
