<?php namespace Modules\WeatherApi\Controller;

use Core\Controller;
use Core\Country;

use Core\Database\Db;

use Web\HttpHeader;

use Views\Json as JsonView;

use Services\HttpService;

use Modules\WeatherApi\Models\Weather;
use Modules\WeatherApi\Models\WeatherCity;

class Get extends Controller
{
    public function init(): void
    {
        $this->view = new JsonView([ 'status' => false ]);

        HttpService::setResponseHeader(new HttpHeader('Content-Type', 'application/json'));
    }

    public function execute(array $params = []): bool
    {
        $city = $params['data']['city'];
        $cityData = WeatherCity::getByTitle($city);

        if ( empty($cityData) ) {
            HttpService::setResponseCode(400);

            $this->view->assign([
                'message' => 'Failed to find city with title: ' . $city
            ]);

            return false;
        }

        $weatherData = Weather::getLastByCityId($cityData['id']);

        if ( empty($weatherData) ) {
            HttpService::setResponseCode(200);

            $this->view->assign([
                'message' => 'Weather data by city id is empty'
            ]);

            return false;
        }

        $weather = new Weather();
        $weather->setModelData($weatherData);

        $this->view->assign([
            'status'  => true,
            'weather' => $weather
        ]);

        return true;
    }
}
