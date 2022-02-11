<?php namespace Web\Controller;

use Core\Controller;

use Views\Index as IndexView;

class Index extends Controller
{
    public function init(): void
    {
        $this->view = new IndexView;
    }

    public function execute(array $params = []): bool
    {
        return true;
    }
}
