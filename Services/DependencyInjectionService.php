<?php namespace Services;

use ReflectionClass;
use ReflectionMethod;

use Services\HelperService;

use Core\DependencyInjection\Action;
use Core\DependencyInjection\Dependency;

use Interfaces\DependencyInjection\Injectable;
use Interfaces\DependencyInjection\InjectionClient;

class DependencyInjectionService
{
    public static function isAction(mixed $isAction): bool
    {
        return $isAction instanceof Action;
    }

    public static function isDependency(mixed $isDependency): bool
    {
        return $isDependency instanceof Dependency;
    }

    public static function isInjectable(mixed $isInjectable): bool
    {
        return $isInjectable instanceof Injectable;
    }

    public static function isInjectionClient(mixed $isClient): bool
    {
        return $isClient instanceof InjectionClient;
    }

    public static function getInstanceFromDependency(Dependency $dependency): Injectable
    {
        $reflectionClass = new ReflectionClass($dependency->getClass());

        $constructorArgs = self::executeActionsRecursive($dependency->getConstructorArgs());

        return $reflectionClass->newInstanceArgs($constructorArgs);
    }

    public static function executeActionsRecursive(array $actionsArray): array
    {
        $executedActions = [];

        foreach ( $actionsArray as $action ) {
            if ( self::isAction($action) ) {
                switch ( $action->getType() ) {
                    case Action::CALL_STATIC_METHOD:
                        $reflectionMethod = new ReflectionMethod($action->getValue());
                        $reflectionArgs = self::executeActionsRecursive($action->getArgs());

                        $value = $reflectionMethod->invokeArgs(null, $reflectionArgs);
                    break;

                    case Action::SEND_STATIC_VALUE:
                        $value = $action->getValue();
                    break;
                }
            }

            if ( HelperService::isSet($value) === false ) {
                continue;
            }

            $executedActions[] = $value;
        }

        return $executedActions;
    }

    public static function injectInstance(InjectionClient $client, Injectable $injectable, string $property): bool
    {
        return $client->inject($property, $injectable);
    }
}
