<?php namespace Modules\WebFrontend\Controller;

use Core\Context;

use Core\Hook\HookProvider;

use Models\Module;
use Models\Country;

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

        $this->appendModulesItemsIntoDocument();
        $this->appendWeatherApiItemsIntoDocument();

        return true;
    }

    private function isAdminAccess(): bool
    {
        return Context::getInstance()->user->isAdmin();
    }

    private function appendModulesItemsIntoDocument(): void
    {
        $this->view->assign([
            'modules' => Module::getAll()
        ]);
    }

    private function appendWeatherApiItemsIntoDocument(): void
    {
        $this->view->assign([
            'weather' => [
                'api' => $this->getWeatherApiConfigHookData()
            ]
        ]);
    }

    private function getWeatherApiConfigHookData(): array
    {
        $hookResultCollection = HookProvider::execute('getWeatherApiConfig');
        $hookResult = $hookResultCollection->getItemByIndex(0);

        if ( $hookResult && $hookResult->isSuccess() ) {
            $hookData = $hookResult->getData();
        } else {
            $hookData = [
                'key' => '',
                'uri' => ''
            ];
        }

        return $hookData;
    }
}
