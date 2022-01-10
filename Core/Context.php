<?php namespace Core;

use Interfaces\Singleton;
use Interfaces\Application;
use Interfaces\ApplicationRequest;

use Interfaces\DependencyInjection\Injectable;
use Interfaces\DependencyInjection\InjectionClient;

class Context implements Singleton, InjectionClient
{
    private static Context $_INSTANCE;

    private Application $application;
    private ApplicationRequest $applicationRequest;

    public static function getInstance(): self
    {
        return self::$_INSTANCE;
    }

    public static function setInstance(Context $instance): bool
    {
        if ( isset(self::$_INSTANCE) === false ) {
            self::$_INSTANCE = $instance;

            return true;
        }

        return false;
    }

    public function __get(string $property): mixed
    {
        return $this->$property;
    }

    public function inject(string $prop, Injectable $injectable): bool
    {
        if ( isset($this->$prop) === false ) {
            $this->$prop = $injectable;

            return $this->$prop->onInjected();
        }

        return false;
    }

    public function eject(string $prop): bool
    {
        $status = $this->$prop->onEjected();

        unset($this->$prop);

        return $status;
    }
}
