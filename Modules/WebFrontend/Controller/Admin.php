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
        $weatherApiConfigData = $this->getWeatherApiConfigHookData();

        $weatherApiKey = $weatherApiConfigData['key'];
        $weatherApiUri = $weatherApiConfigData['uri'];

        $weatherApiCities = $this->getWeatherApiCities();

        $countries = Country::getAll();
        $countriesOptions = [];

        foreach ( $countries as $country ) {
            $countriesOptions[] = [
                'id' => $country['id'],
                'title' => $country['title'],
                'value' => $country['iso']
            ];
        }

        $this->view->assign([
            'weather' => [
                'api' => [
                    'key'       => $weatherApiKey,
                    'uri'       => $weatherApiUri,
                    'cities'    => $weatherApiCities,
                    'countries' => $countriesOptions
                ]
            ]
        ]);

        $this->addCountriesAndCitiesToDocument($countries, $weatherApiCities);
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

    private function getWeatherApiCities(): array
    {
        $hookResultCollection = HookProvider::execute('getWeatherCities');
        $hookResult = $hookResultCollection->getItemByIndex(0);

        if ( $hookResult && $hookResult->isSuccess() ) {
            $weatherCityCollection = $hookResult->getData();
        } else {
            $weatherCityCollection = [];
        }

        $weatherApiCities = [];

        foreach ( $weatherCityCollection as $weatherCity ) {
            $weatherApiCities[] = [
                'id'        => $weatherCity->id,
                'title'     => $weatherCity->title,
                'latitude'  => $weatherCity->latitude,
                'longitude' => $weatherCity->longitude,
                'active'    => $weatherCity->active,
                'country'   => $weatherCity->country,
                'value'     => $weatherCity->latitude . ' ' . $weatherCity->longitude
            ];
        }

        return $weatherApiCities;
    }

    private function addCountriesAndCitiesToDocument(array $countries, array $cities): void
    {
        $this->addJsonObjectToDocument([
            'countries' => $countries,
            'cities'    => $cities
        ]);
    }
}
