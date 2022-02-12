<?php namespace Modules\AuthModule;

use Core\Route;
use Core\Context;
use Core\AbstractModule;

class AuthModule extends AbstractModule
{
    public function init(): void
    {
        $routes = [];

        $routes[] = new Route('/login', 1, "{$this->namespace}\\Controller\\Login", [ 'GET', 'POST' ], true);
        $routes[] = new Route('/logout', 1, "{$this->namespace}\\Controller\\Logout", [ 'GET' ], true);
        $routes[] = new Route('/register', 1, "{$this->namespace}\\Controller\\Register", [ 'POST' ], true);

        $this->setRoutes($routes);
    }

    private function setRoutes(array $routes): void
    {
        $router = Context::getInstance()->application->getRouter();

        foreach ( $routes as $route ) {
            $router->setRoute($route);
        }
    }
}
