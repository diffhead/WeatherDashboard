<?php namespace Modules\WebFrontend\Controller;

class Index extends WebFrontendController
{
    public function execute(array $params = []): bool
    {
        $this->setEntity(WebFrontendController::ENTITY_INDEX);

        return true;
    }
}
