<?php namespace Core;

use Services\ArrayService;

class Model extends ActiveRecord
{
    public function __construct(int $id = 0)
    {
        if ( $id ) {
            $modelData = (array)ArrayService::pop($this->where($this->getAloneItemWhereStatement($id)));

            $this->setModelData($modelData);
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
}
