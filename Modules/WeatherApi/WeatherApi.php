<?php namespace Modules\WeatherApi;

use Core\AbstractModule;
use Core\RouterProvider;

use Core\Hook\Hook;
use Core\Hook\HookCollection;

use Modules\WeatherApi\Models\WeatherCity;
use Modules\WeatherApi\Core\WeatherCityCollection;

use Modules\WeatherApi\Config\WeatherApiConfig;

class WeatherApi extends AbstractModule
{
    public const WEATHER_CITY_ACTIVE = 2;
    public const WEATHER_CITY_INACTIVE = 8;

    public function init(): void 
    {
        $routerProvider = new RouterProvider();
        $routerProvider->setRoutesFromJsonFile($this->path . 'routes.json');
    }

    public function registerHooks(): HookCollection
    {
        return new HookCollection([
            new Hook('getWeatherCities', $this, 'hookGetWeatherCities'),
            new Hook('getWeatherApiConfig', $this, 'hookGetWeatherApiConfig')
        ]);
    }

    public function hookGetWeatherCities(int $activeFlag = WeatherApi::WEATHER_CITY_ACTIVE | WeatherApi::WEATHER_CITY_INACTIVE): WeatherCityCollection
    {
        if ( $activeFlag <= 2 ) {
            $whereStatement = "active = 1";
        } else if ( $activeFlag <= 8 ) {
            $whereStatement = "active = 0";
        } else {
            $whereStatement = "active IN (1,0)";
        }

        $weatherCitiesCollection = new WeatherCityCollection();
        $weatherCities = WeatherCity::where($whereStatement);

        foreach ( $weatherCities as $city ) {
            $weatherCityModel = new WeatherCity();
            $weatherCityModel->setModelData($city);

            $weatherCitiesCollection->putItemIntoCollection($weatherCityModel);
        }

        return $weatherCitiesCollection;
    }

    public function hookGetWeatherApiConfig(): array
    {
        return [
            'key' => WeatherApiConfig::get(WeatherApiConfig::API_KEY),
            'uri' => WeatherApiConfig::get(WeatherApiConfig::API_URI)
        ];
    }
}
