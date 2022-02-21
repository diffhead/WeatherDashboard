<?php namespace Modules\CacheHandler;

use Core\AbstractModule;
use Core\RouterProvider;

class CacheHandler extends AbstractModule
{
    public function init(): void
    {
        $routerProvider = new RouterProvider();
        $routerProvider->setRoutesFromJsonFile($this->path . 'routes.json');
    }
}
