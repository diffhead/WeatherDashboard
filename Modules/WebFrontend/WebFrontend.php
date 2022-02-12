<?php namespace Modules\WebFrontend;

use Core\Route;
use Core\Context;
use Core\AbstractModule;
use Core\ModulesRegistry;

class WebFrontend extends AbstractModule
{
    public function init(): void
    {
        ModulesRegistry::getModule('RoutesHandler')->setRoutesFromJsonFile($this->path . 'routes.json');
    }
}
