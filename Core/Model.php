<?php namespace Core;

use Services\ClassService;
use Services\ArrayService;
use Services\StringService;

class Model extends ActiveRecord
{
    public function __construct(int $id = 0)
    {
        if ( $id ) {
            $modelData = ArrayService::pop($this->where($this->getAloneItemWhereStatement($id)));

            $this->setModelData($modelData);
        }
    }

    private function getAloneItemWhereStatement(int $primaryFieldValue): string
    {
        $idField = static::$idField;

        return "{$idField}={$primaryFieldValue}";
    }

    public function setModelData(array $properties = []): void
    {
        foreach ( $properties as $property => $value ) {
            $this->__set($property, $value);
        }
    }

    public function __get(string $property): mixed
    {
        if ( ClassService::propertyExists($this, $property) || $property === static::$idField ) {
            if ( $property === static::$idField ) {
                return $this->id;
            }

            return $this->$property;
        }

        return null;
    }

    public function __set(string $property, mixed $value): void
    {
        if ( ClassService::propertyExists($this, $property) || $property === static::$idField ) {
            if ( $property === static::$idField ) {
                $this->id = $value;
            } else {
                $this->$property = $value;
            }
        }
    }

    public function isValidModel(): bool
    {
        $properties = ClassService::getProperties($this);

        foreach ( $properties as $property ) {
            if ( isset($this->$property) === false ) {
                return false;
            }
        }

        return true;
    }
}
