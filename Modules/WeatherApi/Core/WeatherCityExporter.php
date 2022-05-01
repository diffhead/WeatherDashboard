<?php namespace Modules\WeatherApi\Core;

use Generator;

use Core\Hook\HookProvider;

use Models\Country;

use Services\ArrayService;
use Services\StringService;

use Modules\WeatherApi\Models\WeatherCity;

class WeatherCityExporter
{
    private CityExportCSV $csv;
    private Generator     $items;

    /* [ ISO => Models\Country ] */
    private array $countries = [];
    private int   $exportedCities = 0;

    public function __construct(string $pathToCSV)
    {
        $this->csv = new CityExportCSV($pathToCSV);
        $this->items = $this->csv->getItems();
    }

    public function export(): void
    {
        foreach ( $this->items as $item ) {
            $country = $this->initCountry($item['country']);
            $city = $item['city'];

            if ( $country->isValidModel() === false ) {
                continue;
            }

            if ( $this->isCityExists($city['title']) === false ) {
                if ( $this->exportCity($city, $country) ) {
                    $this->exportedCities += 1;
                }
            }
        }
    }

    private function initCountry(array $country): Country
    {
        $countryISO = $country['iso'];
        $countryTitle = StringService::trim($country['title']);
        $countryTitleRegex = "/[a-z,A-Z,á,é,í,ó,ú,â,ê,ô,ã,õ,ç,Á,É,Í,Ó,Ú,Â,Ê,Ô,Ã,Õ,Ç,ü,ñ,Ü,Ñ,' ']+/m";

        if ( isset($this->countries[$countryISO]) ) {
            return $this->countries[$countryISO];
        }

        $countrySearching = Country::where("iso = '$countryISO'");
        $countryInstance = new Country();

        if ( $countrySearching ) { 
            $countryInstance->setModelData(ArrayService::pop($countrySearching));
        } else {
            if ( StringService::isMatch($countryTitleRegex, $countryTitle) ) {
                $countryInstance->setModelData($country);
                $countryInstance->create();

                /* Country::where caches data */
                HookProvider::execute('flushCache');
            }
        }

        $this->countries[$countryISO] = $countryInstance;

        return $countryInstance;
    }

    private function isCityExists(string $title): bool
    {
        $city = WeatherCity::getByTitle($title);

        return (bool)$city;
    }

    private function exportCity(array $city, Country $country): bool
    {
        $cityModel = new WeatherCity();
        $cityModel->setModelData(
            ArrayService::merge([
                'active'  => 1,
                'country' => $country->id
            ], $city)
        );

        return $cityModel->create();
    }

    public function doSomethingExported(): bool
    {
        return (bool)$this->exportedCities;
    }
}
