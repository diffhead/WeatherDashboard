<?php namespace Modules\RoutesHandler;

use Exception;

use Core\Cache;
use Core\Route;
use Core\Context;
use Core\FileStream;
use Core\GlobalConfig;
use Core\AbstractModule;

use Services\JsonService;

class RoutesHandler extends AbstractModule
{
    private int $enableCaching = 0;

    public function init(): void 
    {
        $cache = new Cache('RoutesHandler.config.enableCaching', 3600);

        $enableCaching = $cache->getData();

        if ( $enableCaching === false ) {
            $enableCaching = (int)GlobalConfig::get('ROUTES_HANDLER_CACHING');

            $cache->setData($enableCaching);
        }

        $this->enableCaching = $enableCaching;
    }

    public function enableCaching(): bool
    {
        $cache = new Cache('RoutesHandler.config.enableCaching', 3600);
        $cache->setData(1);

        $this->enableCaching = 1;

        return GlobalConfig::set('ROUTES_HANDLER_CACHING', '1');
    }

    public function disableCaching(): bool
    {
        $cache = new Cache('RoutesHandler.config.enableCaching', 3600);
        $cache->setData(0);

        $this->enableCaching = 0;

        return GlobalConfig::set('ROUTES_HANDLER_CACHING', '0');
    }

    public function setRoutesFromJsonFile(string $jsonPath): bool
    {
        $routes = $this->getRoutesFromJsonFile($jsonPath);

        foreach ( $routes as $route ) {
            $this->setRoute($route);
        }

        return true;
    }

    public function getRoutesFromJsonFile(string $pathToJson): array
    {
        $routesJson = $this->getFromCache("RoutesHandler.getRoutesFromJsonFile.$pathToJson");

        if ( $routesJson === false ) {
            $routesFile = new FileStream($pathToJson);

            if ( $routesFile->open() === false ) {
                throw new Exception("Failed to open '$pathToJson'");
            }

            $routesText = $routesFile->read();
            $routesJson = JsonService::decode($routesText);

            if ( JsonService::lastError() !== JSON_ERROR_NONE ) {
                throw new Exception("File '$pathToJson' contains invalid json data");
            }

            $this->pushTocache("RoutesHandler.getRoutesFromJsonFile.$pathToJson", $routesJson);
        }

        $routes = [];

        foreach ( $routesJson as $route => $data ) {
            $routes[] = new Route(
                $route, $data['type'], $data['controller'], $data['params'], $data['protected']
            );
        }

        return $routes;
    }

    private function pushToCache(string $key, mixed $data): bool
    {
        if ( $this->enableCaching ) {
            $cache = new Cache($key, 3600 * 24);

            return $cache->setData($data);
        }

        return false;
    }

    private function getFromCache(string $key): mixed
    {
        if ( $this->enableCaching ) {
            $cache = new Cache($key, 3600 * 24);

            return $cache->getData();
        }

        return false;
    }

    public function setRoute(Route $route): int
    {
        return Context::getInstance()->application->getRouter()->setRoute($route);
    }
}
