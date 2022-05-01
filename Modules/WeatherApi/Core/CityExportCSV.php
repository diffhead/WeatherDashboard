<?php namespace Modules\WeatherApi\Core;

use Generator;

use Core\Database\Db;

use Core\Path\File;
use Core\FileStream;

use Services\StringService;

use Interfaces\Database\Connection;

class CityExportCSV
{
    public const COL_CITY_NAME    = 'city_ascii';
    public const COL_CITY_LAT     = 'lat';
    public const COL_CITY_LON     = 'lng';
    public const COL_COUNTRY_NAME = 'country';
    public const COL_COUNTRY_ISO  = 'iso2';

    private ?int $iCityName    = null;
    private ?int $iCityLat     = null;
    private ?int $iCityLon     = null;
    private ?int $iCountryName = null;
    private ?int $iCountryISO  = null;

    private bool $foundAllIndexes = false;

    private ?FileStream $file = null;
    private ?Connection $db = null;

    public function __construct(string $pathToCSV)
    {
        $file = new File($pathToCSV);

        if ( $file->isExists() ) {
            $this->file = new FileStream($pathToCSV);
            $this->file->open();
            $this->db = Db::getConnection();
        }
    }

    public function getItems(): Generator
    {
        $lines = $this->file->getLines();
        $first = true;

        while ( $line = $lines->current() ) {
            $lines->next();

            $line = StringService::strReplace($line, '"', '');
            $lineItems = StringService::explode($line, ',');

            if ( $first ) {
                $first = false;

                $this->initColumnIndexes($lineItems);
            } else {
                if ( $this->foundAllIndexes ) {
                    yield $this->getExportItem($lineItems);
                }
            }
        }

        return [];
    }

    private function initColumnIndexes(array $item): void
    {
        foreach ( $item as $index => $prop ) {
            switch ( $prop ) {
                case self::COL_CITY_NAME:
                    $this->iCityName = $index; break;
                case self::COL_CITY_LAT:
                    $this->iCityLat = $index; break;
                case self::COL_CITY_LON:
                    $this->iCityLon = $index; break;
                case self::COL_COUNTRY_NAME:
                    $this->iCountryName = $index; break;
                case self::COL_COUNTRY_ISO:
                    $this->iCountryISO = $index; break;
            }
        }

        $this->foundAllIndexes = $this->iCityName    !== null &&
                                 $this->iCityLat     !== null &&
                                 $this->iCityLon     !== null &&
                                 $this->iCountryName !== null &&
                                 $this->iCountryISO  !== null;
    }

    private function getExportItem(array $item): array
    {
        return [
            'city' => [
                'title'     => $this->db->escapeString($item[$this->iCityName]),
                'latitude'  => $this->db->escapeString($item[$this->iCityLat]),
                'longitude' => $this->db->escapeString($item[$this->iCityLon])
            ],
            'country' => [
                'title' => $this->db->escapeString($item[$this->iCountryName]),
                'iso'   => $this->db->escapeString($item[$this->iCountryISO])
            ]
        ];
    }

    public function __destruct()
    {
        if ( $this->file ) {
            $this->file->close();
        }
    }
}
