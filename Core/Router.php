<?php namespace Core;

class Router
{
    const SET_ROUTE_FAILED = 0;
    const SET_ROUTE_SUCCESS = 1;
    const SET_ROUTE_CHANGED = -1;

    private array $routes = [];

    public function isRouteExists(string $route): bool
    {
        return isset($this->routes[$route]);
    }

    public function setRoute(string $route, Route $routeInstance): int
    {
        $status = self::SET_ROUTE_SUCCESS;

        if ( $this->isRouteExists($route) ) {
            if ( $this->getRoute($route)->isProtected() ) {
                return self::SET_ROUTE_FAILED;
            }

            $status = self::SET_ROUTE_CHANGED;
        }

        $this->routes[$route] = $routeInstance;

        return $status;
    }

    public function getRoute(string $route): null|Route
    {
        static $matches = [];

        if ( isset($matches[$route]) ) {
            return $matches[$route];
        }

        foreach ( $this->routes as $routeAddress => $routeInstance ) {
            if ( $routeInstance->isCurrentRoute($route) ) {
                $matches[$route] = $routeInstance;

                return $routeInstance;
            }
        }

        return null;
    }
}
