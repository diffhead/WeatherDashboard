<?php namespace Modules\WebFrontend\Controller;

use Core\Context;
use Core\ModulesRegistry;

use Models\Module;

use Services\HttpService;

class Admin extends WebFrontendController
{
    public function execute(array $params = []): bool
    {
        $this->setEntity(WebFrontendController::ENTITY_ADMIN);

        if ( $this->isAdminAccess() === false ) {
            HttpService::setResponseCode(401);

            $this->view->assign([ 
                'error' => 'You dont have permissions to do that' 
            ]);

            return false;
        }

        $this->view->assign([
            'modules' => Module::getAll()
        ]);

        return true;
    }

    private function isAdminAccess(): bool
    {
        return Context::getInstance()->user->isAdmin();
    }
}
