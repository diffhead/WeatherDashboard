<?php namespace Modules\ModulesHandler;

use Core\RouterProvider;
use Core\AbstractModule;

class ModulesHandler extends AbstractModule
{
    public function init(): void
    {
        $routerProvider = new RouterProvider();
        $routerProvider->setRoutesFromJsonFile($this->path . 'routes.json');
    }
}
