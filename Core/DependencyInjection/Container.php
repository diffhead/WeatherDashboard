<?php namespace Core\DependencyInjection;

use Exception;
use ReflectionClass;

use Services\JsonService;
use Services\ArrayService;
use Services\StringService;
use Services\HelperService;
use Services\DependencyInjectionService;

use Factories\DependencyInjection\ActionFactory;
use Factories\DependencyInjection\DependencyFactory;

use Interfaces\DependencyInjection\Injectable;
use Interfaces\DependencyInjection\InjectionClient;

use Core\FileStream;

class Container 
{
    private string $name;
    private string $class;
    private array  $constructorArgs;

    private static array $containers;
    private static array $dependencies;

    private static function init(): void
    {
        $containers = new FileStream(_APP_BASE_DIR_ . 'containers.json');
        $containers->open();

        $containersText = $containers->read();

        $containers->close();

        $containersJson = [];
        $dependenciesArray = [];

        if ( StringService::isEmpty($containersText) === false ) {
            $containersJsonDecoded = JsonService::decode($containersText);

            if ( JsonService::lastError() === JSON_ERROR_NONE ) {
                foreach ( $containersJsonDecoded as $containerName => $containerData ) {
                    foreach ( $containerData['dependencies'] as $entity => $dependencies ) {
                        $dependenciesArray[$entity] = DependencyFactory::getDependenciesFromArray(
                            $dependencies
                        );
                    }
                }

                $containersJson = $containersJsonDecoded;
            }
        }

        self::$containers = $containersJson;
        self::$dependencies = $dependenciesArray;
    }

    public function __construct(string $containerName)
    {
        if ( isset(self::$containers) === false ) {
            self::init();
        }

        if ( HelperService::isSet(self::$containers[$containerName]) === false ) {
            throw new Exception("Container '$containerName' not found");
        }

        $this->name = $containerName;

        $this->initContainerData();
    }

    private function initContainerData(): void
    {
        $containerData = $this->getContainerData($this->name);

        $this->class = $containerData['class'];

        $this->constructorArgs = ActionFactory::getActionsFromArrayRecursive(
            $containerData['constructor-args']
        );
    }

    private function getContainerData(string $containerName): array
    {
        return (array)self::$containers[$containerName];
    }

    private function getDependencies(string $containerEntity): array
    {
        return (array)self::$dependencies[$containerEntity];
    }

    private function getConstructorArgs(): array
    {
        return $this->constructorArgs;
    }

    public function get(string $entity): InjectionClient
    {
        $dependencies = $this->getDependencies($entity);

        $reflectionClass = new ReflectionClass($this->class);

        $constructorArgs = $this->getConstructorArgs();
        $constructorArgsExecuted = DependencyInjectionService::executeActionsRecursive(
            $constructorArgs, true
        );

        $client = $reflectionClass->newInstanceArgs($constructorArgsExecuted);

        if ( DependencyInjectionService::isInjectionClient($client) === false ) {
            throw new Exception("'{$this->class}' instance is not an InjectionClient");
        }

        foreach ( $dependencies as $dependency ) {
            if ( DependencyInjectionService::isDependency($dependency) ) {
                $instance = DependencyInjectionService::getInstanceFromDependency($dependency);

                if ( DependencyInjectionService::isInjectable($instance) ) {
                    DependencyInjectionService::injectInstance(
                        $client, $instance, $dependency->getProperty()
                    );
                }
            }
        }

        return $client;
    }
}
