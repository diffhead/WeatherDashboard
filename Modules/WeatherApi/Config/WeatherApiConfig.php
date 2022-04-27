<?php namespace Modules\WeatherApi\Config;

use Core\Cache;
use Core\FileStream;

use Interfaces\Configuration;

use Services\JsonService;

use Modules\WeatherApi\Views\WeatherApiConfigTemplate;

class WeatherApiConfig implements Configuration
{
    public const API_KEY = 'apikey';
    public const API_URI = 'apiuri';

    private static ?array $config = null;
    private static string $configPath = _APP_BASE_DIR_ . 'Modules/WeatherApi/config.json';

    public static function set(string $code, mixed $value): bool
    {
        if ( self::$config === null ) {
            self::initConfig();
        }

        self::$config[$code] = $value;

        return self::writeNewConfig();
    }

    private static function initConfig(): void
    {
        $cache = new Cache('weatherApi.config', 3600 * 24);

        $config = $cache->getData();

        if ( $config === false ) {
            $configFile = new FileStream(self::$configPath);

            if ( $configFile->open() ) {
                $configText = $configFile->read();
                $configJson = JsonService::decode($configText);

                if ( JsonService::lastError() !== JSON_ERROR_NONE ) {
                    throw new Exception('Failed config file json decoding');
                }

                $cache->setData($configJson);
            }
        } else {
            $configJson = $config;
        }

        if ( isset($configJson) ) {
            self::$config = $configJson;
        } else {
            self::$config = [];
        }

    }

    private static function writeNewConfig(): bool
    {
        if ( 
            isset(self::$config['weatherApi'])           === false ||
            isset(self::$config['weatherApi']['apikey']) === false ||
            isset(self::$config['weatherApi']['apiuri']) === false
        ) {
            return false;
        }

        $fileView = new WeatherApiConfigTemplate();
        $fileView->assign([
            'weatherApiKey' => self::$config['apikey'],
            'weatherApiUri' => self::$config['apiuri']
        ]);

        $file = new FileStream(self::$configPath);
        $writeStatus = false;

        if ( $file->open() || $file->touch() ) {
            $writeStatus = $file->write($fileView->render());
        }

        return $writeStatus;
    }

    public static function get(string $code): mixed
    {
        if ( self::$config === null ) {
            self::initConfig();
        }

        return self::$config[$code];
    }
}
