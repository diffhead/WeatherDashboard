<?php namespace Models;

use Core\Model;
use Core\ActiveRecord;

class Country extends Model
{
    protected string $title;
    protected string $iso;
    protected string $itu;

    protected static string $idField = 'id';
    protected static string $table = 'country';

    protected static bool   $dataCaching = true;

    protected static array  $definitions = [
        'id'    => ActiveRecord::TYPE_INT,
        'title' => ActiveRecord::TYPE_STRING,
        'iso'   => ActiveRecord::TYPE_STRING,
        'itu'   => ActiveRecord::TYPE_STRING
    ];
}
