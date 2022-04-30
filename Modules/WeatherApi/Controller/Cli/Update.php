<?php namespace Modules\WeatherApi\Controller\Cli;

use Core\Context;
use Core\Controller;

use Cli\ErrorCode;

use Views\StdOut;

use Modules\WeatherApi\Models\WeatherCity;
use Modules\WeatherApi\Core\WeatherDownloader;
use Modules\WeatherApi\Config\WeatherApiConfig;

class Update extends Controller
{
    public function init(): void
    {
        $this->view = new StdOut();
    }

    public function execute(array $params = []): bool
    {
        $user = Context::getInstance()->user;

        if ( $user->isAdmin() === false ) {
            $this->view->setCode(ErrorCode::ACCESS_DENIED);
            $this->view->setMessage('You dont have permissions to do that');

            return false;
        }

        return $this->downloadWeatherRecords();
    }

    private function downloadWeatherRecords(): bool
    {
        $cities = WeatherCity::where("active = '1'");

        $appid = $this->getConfigApiKey();
        $errors = [];

        foreach ( $cities as $city ) {
            $wCity = new WeatherCity();
            $wCity->setModelData($city);

            $wDownloader = new WeatherDownloader($appid, $wCity);

            $weather = $wDownloader->download();

            if ( $weather->create() === false ) {
                $errors[] = $wCity->title;
            }
        }

        if ( empty($errors) === false ) {
            $this->view->setCode(ErrorCode::ERR_HAVE_ERRORS);
            $this->view->setMessage(
                'Failed to update these cities: ' . PHP_EOL . implode(',', $errors) . PHP_EOL
            );

            return false;
        }

        $this->view->setMessage('Successfully weather records updating');

        return true;
    }

    private function getConfigApiKey(): string
    {
        return WeatherApiConfig::get(WeatherApiConfig::API_KEY);
    }
}
