<?php namespace Modules\WeatherApi\Controller\Web;

use Core\Context;
use Core\Controller;

use Core\Database\Db;

use Services\HttpService;
use Services\ArrayService;

use Views\Json as JsonView;

use Modules\WeatherApi\Models\WeatherCity;

class UpdateApiCity extends Controller
{
    public function init(): void 
    {
        $this->view = new JsonView([ 'status' => false ]);
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

        $cityId = (int)$params['data']['id'] ?: 0;
        $latitude = (float)$params['data']['latitude'] ?: 0;
        $longitude = (float)$params['data']['longitude'] ?: 0;

        if ( $cityId === 0 || ($latitude === 0 && $longitude === 0) ) {
            HttpService::setResponseCode(400);

            $this->view->assign([
                'message' => 'You need to pass correct data'
            ]);

            return false;
        }

        $city = new WeatherCity($cityId);

        if ( $city->isValidModel() === false ) { 
            HttpService::setResponseCode(400);

            $this->view->assign([
                'message' => 'City with current id not found'
            ]);

            return false;
        }

        $city->latitude = $latitude;
        $city->longitude = $longitude;

        if ( $city->update() === false ) {
            HttpService::setResponseCode(500);

            $this->view->assign([
                'message' => 'Failed to saving city data'
            ]);

            return false;
        }

        $this->view->assign([
            'status'  => true,
            'message' => 'Success city saving'
        ]);

        return true;
    }
}
