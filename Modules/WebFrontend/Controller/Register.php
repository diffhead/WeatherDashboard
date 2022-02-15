<?php namespace Modules\WebFrontend\Controller;

class Register extends WebFrontendController
{
    public function execute(array $params = []): bool
    {
        $this->setEntity(WebFrontendController::ENTITY_REGISTER);

        return true;
    }
}
