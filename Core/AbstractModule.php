<?php namespace Core;

use Core\Model;

use Interfaces\Module;

abstract class AbstractModule implements Module
{
    protected Model $model;

    protected bool   $enable;

    protected string $name;
    protected string $path;

    abstract public function init(): void;

    final public function __construct(Model $model)
    {
        $this->model = $model;

        $this->name = $model->name;
        $this->enable = $model->enable;
        $this->path = _MODULES_DIR_ . $model->name . '/';
    }

    public function enable(): bool
    {
        $this->model->enable = true;

        return $this->model->update();
    }

    public function disable(): bool
    {
        $this->model->enable = false;

        return $this->model->update();
    }

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
