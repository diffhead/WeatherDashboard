<?php namespace Factories\DependencyInjection;

use Factories\AbstractFactory;

class DependencyFactory extends AbstractFactory
{
    protected static string $class = '\\Core\\DependencyInjection\\Dependency';

    public static function getDependenciesFromArray(array $dependencies): array
    {
        $dependenciesArray = [];

        foreach ( $dependencies as $dependency )
        {
            $dependenciesArray[] = static::get(
                $dependency['class'], $dependency['property'], $dependency['constructor-args']
            );
        }

        return $dependenciesArray;
    }
}
