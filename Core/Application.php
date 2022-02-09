<?php namespace Core;

use ReflectionClass;
use Exception;

use Interfaces\Controller;
use Interfaces\ApplicationRequest;

use Core\Router;
use Core\Display;

use Services\HelperService;
use Services\ArrayService;
use Services\ApplicationService;

class Application
{
    const WEB_ENVIRONMENT = 1;
    const CLI_ENVIRONMENT = 2;

    private Router $router;
    private Display $display;

    public function __construct(Router $router, Display $display) 
    {
        $this->router = $router;
        $this->display = $display;
    }

    public function initModules(): bool
    {
        if ( _ENABLE_MODULES_ ) {
        }

        return true;
    }

    public function run(ApplicationRequest $request): void
    {
        $controller = $this->getCurrentController($request);

        $controller->init();
        $controller->execute($request->getRequestData());

        $view = $controller->getView();
        $view->display();

        $this->display->echo();
    }

    private function getCurrentController(ApplicationRequest $request): Controller
    {
        if ( _APP_ENVIRONMENT_ === self::WEB_ENVIRONMENT ) {
            $route = $this->router->getRoute($request->getRequestData()['url']);

            if ( $route && ArrayService::inArray($route->getParams(), $request->getMethod()) === false ) {
                $controller = new \Web\Controller\Error(405, 'Method not allowed');
            } else if ( HelperService::isNull($route) ) {
                $controller = new \Web\Controller\Error(404, 'Route not found');
            }
        } else {
            $route = $this->router->getRoute($request->getRequestData()['action']);

            if ( HelperService::isNull($route) ) {
                $controller = new \Cli\Controller\Error('Route not found');
            }
        }

        if ( isset($controller) === false && $route ) {
            $controllerClass = $route->getController();
            $controller = new $controllerClass();
        }

        if ( ApplicationService::isController($controller) === false ) {
            throw new Exception("Current route's controller must to implement controller interface");
        }

        Context::getInstance()->controller = $controller;

        return $controller;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }
}
