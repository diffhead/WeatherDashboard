<?php namespace Modules\WebFrontend\Controller;

class Login extends WebFrontendController
{
    public function execute(array $params = []): bool
    {
        $this->setEntity(WebFrontendController::ENTITY_LOGIN);

        return true;
    }
}
