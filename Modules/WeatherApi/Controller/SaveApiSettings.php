<?php namespace Modules\WeatherApi\Controller;

use Core\Context;
use Core\Controller;

use Core\Database\Db;

use Services\HttpService;

use Views\Json as JsonView;

use Modules\WeatherApi\Config\WeatherApiConfig;

class SaveApiSettings extends Controller
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

        if ( isset($params['data']['api']) === false ) {
            HttpService::setResponseCode(400);

            $this->view->assign([
                'message' => 'You need to pass api data'
            ]);

            return false;
        }

        $apiData = $params['data']['api'];

        if ( isset($apiData['key']) === false || isset($apiData['uri']) === false ) {
            HttpService::setResponseCode(400);

            $this->view->assign([
                'message' => 'You need to pass correct data'
            ]);

            return false;
        }

        $db = Db::getConnection();
        $apiKey = $db->escapeString($apiData['key']);
        $apiUri = $db->escapeString($apiData['uri']);

        if ( 
            WeatherApiConfig::set(WeatherApiConfig::API_KEY, $apiKey) === false || 
            WeatherApiConfig::set(WeatherApiConfig::API_URI, $apiUri) === false 
        ) {
            HttpService::setResponseCode(500);

            $this->view->assign([
                'message' => 'Failed to saving config values'
            ]);

            return false;
        }

        $this->view->assign([
            'status'  => true,
            'message' => 'Saving weather api settings successfully'
        ]);

        return true;
    }
}
