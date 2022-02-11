<?php namespace Core;

use Core\Model;

use Interfaces\Module;

abstract class AbstractModule implements Module
{
    protected Model $model;

    protected bool   $enable;

    protected string $name;
    protected string $path;

    final public function __construct(Model $model)
    {
        $this->model = $model;

        $this->name = $model->name;
        $this->enable = $model->enable;
        $this->path = _MODULES_DIR_ . $model->name . '/';
    }

    abstract public function init(): void;
    abstract public function enable(): bool;
    abstract public function disable(): bool;

    public function isEnabled(): bool
    {
        return $this->enable;
    }

    final public function getName(): string
    {
        return $this->name;
    }

    final public function getPath(): string
    {
        return $this->path;
    }
}
