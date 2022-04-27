<?php namespace Modules\WeatherApi\Models;

use DateTime;

class WeatherApiResponse
{
    private string $weather = '';
    private string $weatherDescription = '';
    private string $weatherIcon = '';
    private float  $temperature = 0;
    private float  $temperatureFeeling = 0;
    private int    $visibility = 0;
    private float  $windSpeed = 0;
    private int    $windDeg = 0;
    private string $dateAdd = '0000-00-00';

    public function __construct(array $weatherData)
    {
        $this->weather = $weatherData['weather'][0]['main'] ?: '';
        $this->weatherDescription = $weatherData['weather'][0]['description'] ?: '';
        $this->weatherIcon = $weatherData['weather'][0]['icon'] ?: '';
        $this->temperature = $weatherData['main']['temp'] ?: 0;
        $this->temperatureFeeling = $weatherData['main']['feels_like'] ?: 0;
        $this->visibility = $weatherData['visibility'] ?: 0;
        $this->windSpeed = $weatherData['wind']['speed'] ?: 0;
        $this->windDeg = $weatherData['wind']['deg'] ?: 0;
        $this->dateAdd = (new DateTime('now'))->format('Y-m-d H:i:s');
    }

    public function __get(string $prop): mixed
    {
        return $this->$prop;
    }

    public function __set(string $prop, mixed $value): void
    {
        $this->$prop = $value;
    }
}
