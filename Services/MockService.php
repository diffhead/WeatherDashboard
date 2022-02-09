<?php namespace Services;

class MockService
{
    public static function getRoutes(): array
    {
        return [
            '/' => [
                'type' => 1,
                'controller' => '\\Web\\IndexController',
                'params' => [ 'POST' ],
                'route' => '/'
            ]
        ];
    }
}
