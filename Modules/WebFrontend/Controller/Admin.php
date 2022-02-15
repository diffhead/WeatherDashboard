<?php namespace Modules\WebFrontend\Controller;

class Admin extends WebFrontendController
{
    public function execute(array $params = []): bool
    {
        $this->setEntity(WebFrontendController::ENTITY_ADMIN);

        return true;
    }
}
