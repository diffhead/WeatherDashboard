<?php namespace Models;

use Interfaces\Module as ModuleInterface;

use Core\Model;
use Core\ActiveRecord;

class Module extends Model
{
    protected int    $id;
    protected bool   $enable;
    protected string $name;

    protected static string $table = 'modules';
    protected static string $idField = 'id';

    protected static array  $definitions = [
        'id'      => ActiveRecord::TYPE_INT,
        'enable'  => ActiveRecord::TYPE_BOOL,
        'name'    => ActiveRecord::TYPE_STRING
    ];

    public static function getEnabled(): array
    {
        return static::where("enable = 1");
    }

    public function getModuleInstance(): ModuleInterface
    {
        if ( $this->isValidModel() === true ) {
            throw new Exception("Model is not valid");
        }

        $moduleClass = "\\Modules\\{$this->name}\\{$this->name}";

        return new $moduleClass($this);
    }
}
