<?php namespace Modules\WebFrontend;

use Core\Cache;
use Core\FileStream;
use Core\AbstractModule;
use Core\RouterProvider;

use Services\JsonService;

class WebFrontend extends AbstractModule
{
    public function init(): void
    {
        $routerProvider = new RouterProvider();
        $routerProvider->setRoutesFromJsonFile($this->path . 'routes.json');
    }

    public function getNavigationMenuItems(string $activeEntity): array
    {
        $menuFile = new FileStream($this->path . 'menu.json');
        $menuCache = new Cache("WebFrontend.menu.main", 3600 * 24 * 7);

        $menuJson = $menuCache->getData();

        if ( $menuJson === false && $menuFile->open() === false ) {
            return [];
        }

        if ( $menuJson === false ) {
            $menuText = $menuFile->read();
            $menuJson = JsonService::decode($menuText);

            if ( JsonService::lastError() !== JSON_ERROR_NONE ) {
                return [];
            }

            $menuCache->setData($menuJson);
        }

        foreach ( $menuJson as &$item ) {
            if ( $item['entity'] === $activeEntity ) {
                $item['active'] = true;
            }
        }

        return $menuJson;
    }

    public function getBaseTitle(): string
    {
        return 'Weather Dashboard';
    }
}
