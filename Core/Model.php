<?php namespace Core;

use ReflectionClass;
use ReflectionProperty;

use Services\ArrayService;
use Services\JsonService;

class Model extends ActiveRecord
{
    public function __construct(int $id = 0)
    {
        if ( $id ) {
            $modelData = static::where($this->getAloneItemWhereStatement($id));

            if ( ArrayService::isEmpty($modelData) === false ) {
                $this->setModelData(ArrayService::pop($modelData));
            }
        }
    }

    private function getAloneItemWhereStatement(int $primaryFieldValue): string
    {
        $idField = static::$idField;

        return "{$idField}='{$primaryFieldValue}'";
    }

    public function setModelData(array $properties = []): void
    {
        foreach ( $properties as $property => $value ) {
            $this->__set($property, $value);
        }
    }

    public function isValidModel(): bool
    {
        $properties = ArrayService::getKeys(static::$definitions);

        foreach ( $properties as $property ) {
            if ( isset($this->$property) === false ) {
                return false;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        $reflectionClass = new ReflectionClass(get_class($this));
        $reflectionProperties = $reflectionClass->getProperties(ReflectionProperty::IS_PROTECTED);

        $modelData = [];

        foreach ( $reflectionProperties as $property ) {
            $modelData[$property->getName()] = $property->getValue();
        }

        return JsonService::encode($modelData);
    }
}
