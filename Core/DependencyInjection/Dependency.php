<?php namespace Core\DependencyInjection;

use Services\ArrayService;

use Factories\DependencyInjection\ActionFactory;

class Dependency 
{
    private string $class;
    private string $property;
    private array  $constructorArgs;

    public function __construct(string $class, string $property, array $constructorArgs = [])
    {
        $this->class = $class;
        $this->property = $property;

        if ( ArrayService::isEmpty($constructorArgs) === false ) {
            $this->initConstructorArgs($constructorArgs);
        } else {
            $this->initConstructorArgs([]);
        }
    }

    private function initConstructorArgs(array $args): void
    {
        $this->constructorArgs = ActionFactory::getActionsFromArrayRecursive($args);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getConstructorArgs(): array
    {
        return $this->constructorArgs;
    }
}
