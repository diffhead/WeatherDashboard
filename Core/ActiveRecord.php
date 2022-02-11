<?php namespace Core;

use Exception;

use Core\Database\Db;
use Core\Database\Query;

use Services\ArrayService;

class ActiveRecord
{
    const TYPE_BOOL   = 1;
    const TYPE_INT    = 2;
    const TYPE_FLOAT  = 5;
    const TYPE_STRING = 3;

    protected static string $table;
    protected static string $idField;

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
                if ( $reverse ) {
                    $value = (string)$value;

                    return "'$value'";
                }
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
        if ( static::isValidRecord() === false ) {
            $class = static::class;

            throw new Exception("Current '{$class}' active record is invalid");
        }

        $query = new Query();
        $query->select()->from(static::$table);

        $db = Db::getConnection();
        $db->execute($query);

        return self::filterAll($db->fetch());
    }

    public static function where(string $whereStatement): array
    {
        if ( static::isValidRecord() === false ) {
            $class = static::class;

            throw new Exception("Current '{$class}' active record is invalid");
        }

        $query = new Query;
        $query->select(ArrayService::getKeys(static::$definitions))
              ->from(static::$table)
              ->where($whereStatement);

        $db = Db::getConnection();
        $db->execute($query);

        return self::filterAll($db->fetch());
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

        $idField = static::$idField;

        $query = new Query;
        $query->select([ "MAX({$idField}) as id" ])
              ->from(static::$table);

        $db->execute($query);

        $this->$idField = ArrayService::pop($db->fetch())['id'];

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
