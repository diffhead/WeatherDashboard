<?php namespace Modules\WebFrontend;

use Core\Route;
use Core\Context;
use Core\AbstractModule;

class WebFrontend extends AbstractModule
{
    public function init(): void
    {
        $appRouter = Context::getInstance()->application->getRouter();

        $appRouter->setRoute(
            '/', new Route('/', Route::TYPE_RAW, '\\Modules\\WebFrontend\\Controllers\\Index', [ 'GET', 'POST' ], true)
        );
    }
}
