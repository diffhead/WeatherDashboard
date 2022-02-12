<?php namespace Core;

use ReflectionClass;
use Exception;

use Interfaces\Controller;
use Interfaces\ApplicationRequest;

use Core\Router;
use Core\Display;

use Models\User;
use Models\Module;
use Models\Session;

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
            $modulesDataCache = new Cache('modules.all', 3600, Cache::MEM);

            $modulesData = $modulesDataCache->getData();

            if ( $modulesData === false ) {
                $modulesData = Module::getAll();
                $modulesDataCache->setData($modulesData);
            }

            foreach ( $modulesData as $moduleData ) {
                $moduleModel = new Module;
                $moduleModel->setModelData($moduleData);

                if ( $moduleModel->isValidModel() === false ) {
                    throw new Exception("Invalid module model '{$moduleData['name']}'");
                }

                $moduleClass = "\\Modules\\{$moduleModel->name}\\{$moduleModel->name}";
                $moduleReflector = new ReflectionClass($moduleClass);

                $moduleInstance = $moduleReflector->newInstanceArgs([ $moduleModel ]);

                if ( $moduleInstance->isEnabled() ) {
                    $moduleInstance->init();
                }

                ModulesRegistry::setModule($moduleInstance->getName(), $moduleInstance);
            }

            return true;
        }

        return false;
    }

    public function run(ApplicationRequest $request): void
    {
        $this->initCurrentController($request);
        $this->initCurrentUser($request);

        $context = Context::getInstance();

        $controller = $context->controller;

        $controller->init();
        $controller->execute($request->getRequestData());

        $view = $controller->getView();
        $view->display();

        $this->display->echo();
    }

    private function initCurrentController(ApplicationRequest $request): void
    {
        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            $route = $this->router->getRoute($request->getRequestData()['url']);

            if ( $route ) {
                $routeParams = $route->getParams();

                if ( isset($routeParams['redirect']) ) {
                    $routeRedirect = $routeParams['redirect'];

                    $redirectCode = isset($routeRedirect['code']) ? (int)$routeRedirect['code'] : 303;
                    $redirectTarget = isset($routeRedirect['target']) ? (string)$routeRedirect['target'] : '/';

                    $controller = new \Web\Controller\Redirect($redirectCode, $redirectTarget);
                } else if ( ArrayService::inArray($routeParams, $request->getMethod()) === false ) {
                    $controller = new \Web\Controller\Error(405, 'Request method not allowed');
                }
            } else {
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
    }

    public function initCurrentUser(ApplicationRequest $request): void
    {
        if ( _APP_ENVIRONMENT_ === Application::WEB_ENVIRONMENT ) {
            $cookies = $request->getRequestData()['cookies'];

            $sessionCookie = null;

            foreach ( $cookies as $cookie ) {
                if ( $cookie->getName() === 'stoken' ) {
                    $sessionCookie = $cookie;
                }
            }

            if ( $sessionCookie ) {
                $session = Session::getByToken($cookie->getValue());
            }

            if ( isset($session) && $session->isExpired() === false ) {
                $user = new User($sesion->id);
            } else {
                $user = User::getGuestUser();
            }

            Context::getInstance()->user = $user;
        } else {
        }
    }

    public function getRouter(): Router
    {
        return $this->router;
    }
}
