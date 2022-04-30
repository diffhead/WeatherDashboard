<?php namespace Modules\WeatherApi\Controller;

use Core\Controller;
use Core\Context;

use Web\HttpHeader;

use Views\Json as JsonView;

use Services\HttpService;

use Modules\WeatherApi\Models\Weather;
use Modules\WeatherApi\Models\WeatherCity;

use Modules\WeatherApi\Core\WeatherDownloader;
use Modules\WeatherApi\Core\WeatherApiResponse;

use Modules\WeatherApi\Config\WeatherApiConfig;

class Update extends Controller
{
    public function init(): void
    {
        $this->view = new JsonView([ 'status' => false ]);

        HttpService::setResponseHeader(new HttpHeader('Content-Type', 'application/json'));
    }

    public function execute(array $params = []): bool
    {
        $user = Context::getInstance()->user;

        if ( $user->isAdmin() === false ) {
            HttpService::setResponseCode(401);

            $this->view->assign([
                'message' => 'You dont have permissions to do that'
            ]);

            return false;
        }

        return $this->downloadWeatherRecords();
    }

    private function downloadWeatherRecords(): bool
    {
        $cities = WeatherCity::where("active = '1'");

        $appid = $this->getConfigApiKey();

        $failedWeatherArray = [];
        $successWeatherArray = [];

        foreach ( $cities as $city ) {
            $wCity = new WeatherCity();
            $wCity->setModelData($city);

            $wDownloader = new WeatherDownloader($appid, $wCity);

            $weather = $wDownloader->download();

            if ( $weather->create() ) {
                $successWeatherArray[] = $weather;
            } else {
                $failedWeatherArray[] = $weather;
            }
        }

        if ( empty($failedWeatherArray) === false ) {
            HttpService::setResponseCode(500);

            $this->view->assign([
                'errors'  => $failedWeatherArray,
                'weather' => $successWeatherArray
            ]);

            return false;
        }

        $this->view->assign([ 
            'status'  => true,
            'weather' => $successWeatherArray
        ]);

        return true;
    }

    private function getConfigApiKey(): string
    {
        return WeatherApiConfig::get(WeatherApiConfig::API_KEY);
    }
}
