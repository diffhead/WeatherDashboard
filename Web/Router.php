<?php namespace Web;

use Interfaces\Route;
use Interfaces\Controller;

use Core\AbstractRouter;

class Router extends AbstractRouter
{
    public static function initRoutes(): bool
    {
        return true;
    }

    public function getRouteController(Route $route): Controller
    {
        return Controller;
    }
}
