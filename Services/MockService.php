<?php namespace Services;

class MockService
{
    public static function getRoutes(): array
    {
        return [
            '/' => [
                'type' => 1,
                'controller' => '\\Web\\Controller\\Index',
                'params' => [ 'GET', 'POST' ],
                'route' => '/'
            ]
        ];
    }
}
