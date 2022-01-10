<?php namespace Core;

use Interfaces\Singleton;
use Interfaces\ApplicationRequest;
use Interfaces\Application as ApplicationInterface;
use Interfaces\DependencyInjection\Injectable;

class Application implements ApplicationInterface, Singleton, Injectable
{
    public const WEB_ENVIRONMENT = 1;
    public const CLI_ENVIRONMENT = 2;

    private static Application $_INSTANCE;

    public static function getInstance(): self
    {
        if ( !isset(self::$_INSTANCE) ) {
            self::initInstance();
        }

        return self::$_INSTANCE;
    }

    public static function initInstance(): void
    {
        self::$_INSTANCE = new self();
    }

    public function initModules(): bool
    {
        return true;
    }

    public function run(ApplicationRequest $request): bool
    {
        return true;
    }

    public function terminate(): void
    {
        die('Terminated');
    }

    public function onInjected(): bool
    {
        return true;
    }

    public function onEjected(): bool
    {
        return true;
    }
}
