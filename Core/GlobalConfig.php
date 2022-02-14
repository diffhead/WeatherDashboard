<?php namespace Core;

use Interfaces\Configuration;

use Core\Database\Db;
use Core\Database\Query;

use Services\ArrayService;
use Services\StringService;

class GlobalConfig implements Configuration
{
    public static function get(string $code): mixed
    {
        $query = new Query;
        $query->select([ 'value' ])->from('config')->where("key = '{$code}'");

        $db = Db::getConnection();

        if ( $db->execute($query) ) {
            if ( empty($fetched = $db->fetch()) ) {
                return false;
            }

            return ArrayService::pop($fetched)['value'];
        }

        return false;
    }

    public static function set(string $code, mixed $value): bool
    {
        if ( StringService::isString($value) === false ) {
            throw new Exception("GlobalConfig setter can only using string values");
        }

        $query = new Query;

        /* PGSQL DEPENDENT QUERY */
        $query->setString("
            INSERT INTO config (key, value) VALUES ('$code', '$value') 
            ON CONFLICT (key)
              DO UPDATE 
                    SET value = excluded.value
        ");

        $db = Db::getConnection();

        return $db->execute($query);
    }
}
