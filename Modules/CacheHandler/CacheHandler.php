<?php namespace Modules\CacheHandler;

use Core\Route;
use Core\Context;
use Core\AbstractModule;

class CacheHandler extends AbstractModule
{
    public function init(): void
    {
        Context::getInstance()->application->getRouter()->setRoute(
            new Route('/cache', 1, "{$this->namespace}\\Controller\\Cache", [ 'GET', 'POST' ], true)
        );
    }
}
