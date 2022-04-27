<?php namespace Modules\WeatherApi\Core;

use Web\HttpClient;
use Web\HttpHeader;
use Web\HttpRequest;
use Web\HttpResponse;

use Modules\WeatherApi\Models\Weather;
use Modules\WeatherApi\Models\WeatherCity;
use Modules\WeatherApi\Models\WeatherApiResponse;

use Modules\WeatherApi\Config\WeatherApiConfig;

class WeatherDownloader
{
    private string       $appid;
    private float        $lat;
    private float        $lon;
    private string       $units;
    private string       $lang;

    private ?WeatherCity $city = null;

    public function __construct(string $appid, WeatherCity $city, string $units = 'metric', string $lang = 'en')
    {
        $this->appid = $appid;
        $this->lat = $city->latitude;
        $this->lon = $city->longitude;
        $this->units = $units;
        $this->lang = $lang;

        $this->setCity($city);
    }

    private function setCity(WeatherCity $city): void
    {
        $this->city = $city;
    }

    public function download(): Weather
    {
        $weather = new Weather();

        if ( isset($this->city) === false ) {
            return $weather;
        }

        $uri = WeatherApiConfig::get(WeatherApiConfig::API_URI) . '?';

        $uri .= 'appid=' . $this->appid . '&';
        $uri .= 'lat=' . $this->lat . '&';
        $uri .= 'lon=' . $this->lon . '&';
        $uri .= 'units=' . $this->units . '&';
        $uri .= 'lang=' . $this->lang;

        $httpResponse = $this->sendRequestAndGetResponse($uri);

        if ( $httpResponse ) {
            $weatherData = $httpResponse->getData();

            if ( $weatherData ) {
                $weatherApiResponse = new WeatherApiResponse($weatherData);

                $weather->setModelData([
                    'city'                => $this->city->id,
                    'weather'             => $weatherApiResponse->weather,
                    'weather_description' => $weatherApiResponse->weatherDescription,
                    'weather_icon'        => $weatherApiResponse->weatherIcon,
                    'temperature'         => $weatherApiResponse->temperature,
                    'temperature_feeling' => $weatherApiResponse->temperatureFeeling,
                    'visibility'          => $weatherApiResponse->visibility,
                    'wind_speed'          => $weatherApiResponse->windSpeed,
                    'wind_deg'            => $weatherApiResponse->windDeg,
                    'date_add'            => $weatherApiResponse->dateAdd
                ]);
            }
        }

        return $weather;
    }

    private function sendRequestAndGetResponse(string $uri): ?HttpResponse
    {
        $httpRequest = new HttpRequest($uri, 'GET', [
            new HttpHeader('Connection', 'keep-alive'),
            new HttpHeader('Cache-Control', 'no-cache'),
            new HttpHeader('Pragma', 'no-cache'),
            new HttpHeader('sec-ch-ua', '" Not A;Brand";v="99", "Chromium";v="99'),
            new HttpHeader('sec-ch-ua-mobile', '?0'),
            new HttpHeader('sec-ch-ua-platform', '"Linux"'),
            new HttpHeader('Sec-Fetch-Dest', 'Document'),
            new HttpHeader('Sec-Fetch-Mode', 'navigate'),
            new HttpHeader('Sec-Fetch-Site', 'none'),
            new HttpHeader('Sec-Fetch-User', '?1'),
            new HttpHeader('Upgrade-Insecure-Requests', '1'),
            new HttpHeader('User-Agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36')
        ]);

        $httpClient = new HttpClient($httpRequest);
        $httpClient->sendRequest();

        return $httpClient->getResponse();
    }
}
