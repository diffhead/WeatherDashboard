<?php namespace Modules\WeatherApi\Models;

use Core\Model;
use Core\ActiveRecord;

use Interfaces\CollectionItem;

use Models\Country;

class WeatherCity extends Model implements CollectionItem
{
    protected string $title;
    protected float  $latitude;
    protected float  $longitude;
    protected int    $active;
    protected int    $country;

    protected static string $idField = 'id';
    protected static string $table = 'weather_city';

    protected static bool   $dataCaching = true;

    protected static array  $definitions = [
        'id'        => ActiveRecord::TYPE_INT,
        'title'     => ActiveRecord::TYPE_STRING,
        'latitude'  => ActiveRecord::TYPE_FLOAT,
        'longitude' => ActiveRecord::TYPE_FLOAT,
        'active'    => ActiveRecord::TYPE_INT,
        'country'   => ActiveRecord::TYPE_INT,
    ];

    private ?Country $countryInstance = null;

    public function getValue(string $property): mixed
    {
        return $this->__get($property);
    }

    public function getUniqueId(): string
    {
        return (string)$this->id;
    }

    public function getCountry(): Contry
    {
        if ( $this->countryInstance === null && $this->isValidModel() ) {
            $this->countryInstance = new Country($this->country);
        }

        if ( $this->countryInstance === null && $this->isValidModel() === false ) {
            return new Country();
        }

        return $this->countryInstance;
    }

    public static function getByTitle(string $title): array
    {
        $city = self::where("title='$title'");

        if ( empty($city) ) {
            return [];
        }

        return $city[0];
    }
}
