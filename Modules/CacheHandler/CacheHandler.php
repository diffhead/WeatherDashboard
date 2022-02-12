<?php namespace Modules\CacheHandler;

use Core\Route;
use Core\Context;
use Core\AbstractModule;
use Core\ModulesRegistry;

class CacheHandler extends AbstractModule
{
    public function init(): void
    {
        ModulesRegistry::getModule('RoutesHandler')->setRoutesFromJsonFile($this->path . 'routes.json');
    }
}
