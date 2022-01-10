<?php namespace Factories\DependencyInjection;

use Services\ArrayService;
use Services\DependencyInjectionService;

use Factories\AbstractFactory;

use Core\DependencyInjection\Action;

class ActionFactory extends AbstractFactory
{
    private static array $definedActions = [
        Action::CALL_STATIC_METHOD,
        Action::SEND_STATIC_VALUE
    ];

    protected static string $class = '\\Core\\DependencyInjection\\Action';

    public static function getActionsFromArrayRecursive(array $dependenciesArray): array
    {
        $actionsArray = [];

        foreach ( $dependenciesArray as $dependency ) {
            if ( ArrayService::isArray($dependency) === false ) {
                continue;
            }

            $actionType = isset($dependency[0]) ? (string)$dependency[0] : '';
            $actionValue = isset($dependency[1]) ? (string)$dependency[1] : '';
            $actionArgs = isset($dependency[2]) ? (array)$dependency[2] : [];

            if ( ArrayService::inArray(static::$definedActions, $actionType) === false ) {
                continue;
            }

            if ( ArrayService::isEmpty($actionArgs) === false ) {
                $actionArgs = static::getActionsFromArrayRecursive($actionArgs);
            }

            $actionsArray[] = self::get($actionType, $actionValue, $actionArgs);
        }

        return $actionsArray;
    }
}
