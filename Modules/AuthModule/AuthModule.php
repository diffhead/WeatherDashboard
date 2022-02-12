<?php namespace Modules\AuthModule;

use Core\ModulesRegistry;
use Core\AbstractModule;

class AuthModule extends AbstractModule
{
    public function init(): void
    {
        ModulesRegistry::getModule('RoutesHandler')->setRoutesFromJsonFile($this->path . 'routes.json');
    }
}
