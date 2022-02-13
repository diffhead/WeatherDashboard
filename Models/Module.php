<?php namespace Models;

use Interfaces\Module as ModuleInterface;

use Core\Model;
use Core\ActiveRecord;

use Services\ArrayService;

class Module extends Model
{
    protected bool   $enable;
    protected string $name;
    protected int    $priority;

    protected static string $table = 'modules';
    protected static string $idField = 'id';

    protected static array  $definitions = [
        'id'      => ActiveRecord::TYPE_INT,
        'enable'  => ActiveRecord::TYPE_BOOL,
        'name'    => ActiveRecord::TYPE_STRING,
        'priority' => ActiveRecord::TYPE_INT
    ];

    public static function getAll(): array
    {
        $modulesData = parent::getAll();
        $modulesData = ArrayService::sortMultiArrayByKey($modulesData, 'priority', SORT_ASC);

        return $modulesData;
    }
}
