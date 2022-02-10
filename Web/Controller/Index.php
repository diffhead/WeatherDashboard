<?php namespace Web\Controller;

use Core\Controller;

use Views\Index as IndexView;

use Models\Module;

use Services\MockService;

class Index extends Controller
{
    public function init(): void
    {
        $this->view = new IndexView;
    }

    public function execute(array $params = []): bool
    {
        $modulesData = Module::getAll();

        $this->view->assign([ 
            'title' => 'Weather Dashboard',
            'modules' => $modulesData
        ]);

        return true;
    }
}
