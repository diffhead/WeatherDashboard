<?php namespace Modules\WebFrontend\Controller;

use Core\View;
use Core\Context;
use Core\Controller;
use Core\ModulesRegistry;

use Core\Hook\HookProvider;

use Services\ArrayService;
use Services\StringService;

use Modules\WebFrontend\WebFrontend;
use Modules\WebFrontend\Views\Frontend;

abstract class WebFrontendController extends Controller
{
    const ENTITY_INDEX     = 'index';
    const ENTITY_LOGIN     = 'login';
    const ENTITY_ADMIN     = 'admin';
    const ENTITY_REGISTER  = 'register';

    protected WebFrontend $module;
    protected string      $baseTitle = 'WeatherDashboard';
    protected array       $jsonObjectsForDocument = [];

    final public function init(): void
    {
        $context = Context::getInstance();

        $this->view = new Frontend;
        $this->view->assign([ 'user'  => $context->user ]);

        $this->module = ModulesRegistry::getModule('WebFrontend');
    }

    final protected function setEntity(string $entity): void
    {
        $this->view->assign([
            'entity' => $entity,
            'title'  => $this->getTitleForEntity($entity),
            'menu'   => $this->getMenuForEntity($entity)
        ]);
    }

    protected function getTitleForEntity(string $entity): string
    {
        return $this->module->getBaseTitle() . ' - ' . StringService::ucfirst($entity);
    }

    protected function getMenuForEntity(string $entity): array
    {
        return $this->module->getNavigationMenuItems($entity);
    }

    protected function addJsonObjectToDocument(array $json): void
    {
        $this->jsonObjectsForDocument = ArrayService::merge($this->jsonObjectsForDocument, $json);
    }

    public function execute(array $params = []): bool
    {
        return true;
    }

    public function getView(): View
    {
        $this->view->assign([
            'hooks' => [
                'addJsonObjectToDocument' => $this->jsonObjectsForDocument
            ]
        ]);

        return $this->view;
    }
}
