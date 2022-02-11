<?php namespace Models;

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
}
