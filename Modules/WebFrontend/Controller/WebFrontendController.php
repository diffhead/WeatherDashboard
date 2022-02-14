<?php namespace Modules\WebFrontend\Controller;

use Core\Context;
use Core\Controller;
use Core\ModulesRegistry;

use Modules\WebFrontend\Views\Frontend as FrontendView;

use Services\StringService;

class WebFrontendController extends Controller
{
    const ENTITY_INDEX_ROUTE = '/';
    const ENTITY_LOGIN_ROUTE = '/login';
    const ENTITY_ADMIN_ROUTE = '/admin';

    private string $entity;

    final public function init(): void
    {
        $context = Context::getInstance();
        $entity = $this->getEntityByRequestUrl($context->applicationRequest->getUrl());

        $module = ModulesRegistry::getModule('WebFrontend');
        $title = 'Weather Dashboard - ' . StringService::ucfirst($entity);

        $this->view = new FrontendView;
        $this->view->assign([
            'title'  => $title,
            'entity' => $entity,
            'menu'   => $module->getNavigationMenuItems($entity),
            'user'   => $context->user
        ]);
    }

    private function getEntityByRequestUrl(string $url): string
    {
        switch ( $url ) {
            case WebFrontendController::ENTITY_INDEX_ROUTE:
                return 'index';
            case WebFrontendController::ENTITY_LOGIN_ROUTE:
                return 'login';
            case WebFrontendController::ENTITY_ADMIN_ROUTE:
                return 'admin';
        }
    }

    public function execute(array $params = []): bool
    {
        return true;
    }
}
