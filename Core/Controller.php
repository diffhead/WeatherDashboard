<?php namespace Core;

use Interfaces\View as ViewInterface;
use Interfaces\Controller as ControllerInterface;

class Controller implements ControllerInterface
{
    protected ViewInterface $view;

    public function init(): void
    {
        if ( isset($this->view) === false ) {
            $this->view = new View();
        }
    }

    public function execute(array $params = []): bool
    {
        return true;
    }

    public function getView(): ViewInterface
    {
        return $this->view;
    }
}
