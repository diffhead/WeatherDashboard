<?php namespace Modules\WeatherApi\Core;

use Core\AbstractCollection;

class WeatherCityCollection extends AbstractCollection
{
    protected static string $collectionItemClass = '\\Modules\\WeatherApi\\Models\\WeatherCity';
}
