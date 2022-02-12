<?php namespace Models;

use Interfaces\Module as ModuleInterface;

use Core\Model;
use Core\ActiveRecord;

class Module extends Model
{
    protected bool   $enable;
    protected string $name;

    protected static string $table = 'modules';
    protected static string $idField = 'id';

    protected static array  $definitions = [
        'id'      => ActiveRecord::TYPE_INT,
        'enable'  => ActiveRecord::TYPE_BOOL,
        'name'    => ActiveRecord::TYPE_STRING
    ];
}
