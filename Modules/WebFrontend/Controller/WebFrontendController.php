<?php namespace Modules\WebFrontend\Controller;

use Modules\WebFrontend\WebFrontend;

use Core\Context;
use Core\Controller;
use Core\ModulesRegistry;

use Modules\WebFrontend\Views\Frontend as FrontendView;

use Services\StringService;

abstract class WebFrontendController extends Controller
{
    const ENTITY_INDEX     = 'index';
    const ENTITY_LOGIN     = 'login';
    const ENTITY_ADMIN     = 'admin';
    const ENTITY_REGISTER  = 'register';

    protected WebFrontend $module;
    protected string      $baseTitle = 'WeatherDashboard';

    final public function init(): void
    {
        $context = Context::getInstance();

        $this->view = new FrontendView;
        $this->view->assign([
            'user' => $context->user
        ]);

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

    public function execute(array $params = []): bool
    {
        return true;
    }
}
