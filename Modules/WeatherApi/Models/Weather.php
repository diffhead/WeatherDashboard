<?php namespace Modules\WeatherApi\Models;

use Core\Model;
use Core\Cache;
use Core\ActiveRecord;

use Core\Database\Db;
use Core\Database\Query;

use Interfaces\CollectionItem;

use Services\ArrayService;

class Weather extends Model implements CollectionItem
{
    protected int    $city;

    protected string $weather;
    protected string $weather_icon;
    protected string $weather_description;

    protected string $temperature;
    protected string $temperature_feeling;

    protected int    $visibility;

    protected float  $wind_speed;
    protected int    $wind_deg;

    protected string $date_add;

    protected static string $idField = 'id';
    protected static string $table = 'weather';

    protected static bool   $dataCaching = true;

    protected static array  $definitions = [
        'id'                  => ActiveRecord::TYPE_INT,
        'city'                => ActiveRecord::TYPE_INT,
        'weather'             => ActiveRecord::TYPE_STRING,
        'weather_icon'        => ActiveRecord::TYPE_STRING,
        'weather_description' => ActiveRecord::TYPE_STRING,
        'temperature'         => ActiveRecord::TYPE_FLOAT,
        'temperature_feeling' => ActiveRecord::TYPE_FLOAT,
        'visibility'          => ActiveRecord::TYPE_INT,
        'wind_speed'          => ActiveRecord::TYPE_FLOAT,
        'wind_deg'            => ActiveRecord::TYPE_INT,
        'date_add'            => ActiveRecord::TYPE_STRING
    ];

    public function getValue(string $property): mixed
    {
        return $this->__get($property);
    }

    public function getUniqueId(): string
    {
        return (string)$this->id;
    }

    public static function getLastByCityId(int $cityId): array
    {
        $cache = new Cache("weather.lastByCityId.$cityId", 1800);

        $weatherData = $cache->getData();

        if ( $weatherData === false ) {
            $db = Db::getConnection();

            $maxDateQuery = new Query();
            $maxDateQuery->select([ 'MAX(date_add) as max_date_add' ])->from('weather')->where("city = '$cityId'");
            $maxDateQueryStr = '('. $maxDateQuery->getString() .')';

            $records = self::where("city = '$cityId' and date_add = $maxDateQueryStr");

            if ( $records ) {
                $weatherData = ArrayService::pop($records);
            } else {
                $weatherData = [];
            }
        }

        if ( $weatherData ) {
            $cache->setData($weatherData);
        }

        return $weatherData;
    }
}
