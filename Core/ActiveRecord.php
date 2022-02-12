<?php namespace Core;

use Exception;

use Core\Cache;
use Core\Database\Db;
use Core\Database\Query;

use Services\ArrayService;

class ActiveRecord
{
    const TYPE_BOOL   = 1;
    const TYPE_INT    = 2;
    const TYPE_FLOAT  = 5;
    const TYPE_STRING = 3;

    protected int  $id;

    protected static string $table;
    protected static string $idField;

    protected static bool $dataCaching;

    protected static array $definitions = [
    ];

    protected static function isValidRecord(): bool
    {
        return isset(static::$table)   && empty(static::$table)   === false && 
               isset(static::$idField) && empty(static::$idField) === false;
    }
    /**
     * Reverse flag makes filtering for DB
     */
    public static function filter(string $property, mixed $value, bool $reverse = false): mixed
    {
        if ( isset(static::$definitions[$property]) === false ) {
            return $value;
        }

        switch ( static::$definitions[$property] ) {
            case static::TYPE_BOOL:
                if ( $reverse ) {
                    return (int)$value;
                }
                return (bool)$value;

            case static::TYPE_INT:
                return (int)$value;

            case static::TYPE_FLOAT:
                return (float)$value;

            case static::TYPE_STRING:
                return (string)$value;
        }
    }

    public static function filterAll(array $records): array
    {
        foreach ( $records as &$record ) {
            foreach ( $record as $field => $value ) {
                $record[$field] = self::filter($field, $value);
            }
        }

        return $records;
    }

    public static function getAll(): array
    {
        $class = static::class;

        if ( static::isValidRecord() === false ) {
            throw new Exception("Current '{$class}' active record is invalid");
        }

        $records = false;

        if ( isset(static::$dataCaching) && static::$dataCaching ) {
            $cache = new Cache("ActiveRecord.$class.getAll", 3600 * 24);

            $records = $cache->getData();
        }

        if ( $records === false ) {
            $query = new Query();
            $query->select()->from(static::$table);

            $db = Db::getConnection();
            $db->execute($query);

            $records = self::filterAll($db->fetch());

            if ( isset($cache) ) {
                $cache->setData($records);
            }
        }

        return $records;
    }

    public static function where(string $whereStatement): array
    {
        $class = static::class;

        if ( static::isValidRecord() === false ) {
            throw new Exception("Current '{$class}' active record is invalid");
        }

        $records = false;

        if ( isset(static::$dataCaching) && static::$dataCaching ) {
            $cache = new Cache("ActiveRecord.$class.where.$whereStatement", 3600);

            $records = $cache->getData();
        }

        if ( $records === false ) {
            $query = new Query;
            $query->select(ArrayService::getKeys(static::$definitions))
                  ->from(static::$table)
                  ->where($whereStatement);

            $db = Db::getConnection();
            $db->execute($query);

            $records = self::filterAll($db->fetch());

            if ( isset($cache) ) {
                $cache->setData($records);
            }
        }

        return $records;
    }

    public function create(): bool
    {
        if ( static::isValidRecord() === false ) {
            return false;
        }

        $props = [];
        $values = [];

        foreach ( static::$definitions as $prop => $type ) {
            if ( $prop === static::$idField ) {
                continue;
            }

            if ( isset($this->$prop) === false && static::$idField !== $prop ) {
                return false;
            }

            $value = self::filter($prop, $this->$prop, true);

            $props[] = $prop;
            $values[] = $value;
        }

        $query = new Query;
        $query->insert(static::$table, $props)
              ->values([ $values ]);

        $db = Db::getConnection();

        if ( $db->execute($query) === false ) {
            return false;
        }

        if ( isset($this->id) === false ) {
            $idField = static::$idField;

            $query = new Query;
            $query->select([ "MAX({$idField}) as id" ])
                  ->from(static::$table);

            $db->execute($query);

            $this->id = ArrayService::pop($db->fetch())['id'];
        }

        return true;
    }

    public function update(): bool
    {
        if ( static::isValidRecord() === false ) {
            return false;
        }

        $idField = static::$idField;

        if ( empty($this->$idField) ) {
            return false;
        }

        $query = new Query;
        $query->update(static::$table);

        foreach ( static::$definitions as $prop => $type ) {
            if ( $prop === static::$idField ) {
                continue;
            }

            if ( isset($this->$prop) === false && static::$idField !== $prop ) {
                return false;
            }

            $query->set($prop, self::filter($prop, $this->$prop, true));
        }

        $query->where("{$idField}={$this->$idField}");

        $db = Db::getConnection();

        return $db->execute($query);
    }

    public function delete(): bool
    {
        if ( static::isValidRecord() === false ) {
            return false;
        }

        $idField = static::$idField;

        if ( empty($this->$idField) ) {
            return false;
        }

        $query = new Query;
        $query->delete()
              ->from(static::$table)
              ->where("{$idField}={$this->$idField}");

        $db = Db::getConnection();

        return $db->execute($query);
    }
}
