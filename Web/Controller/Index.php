<?php namespace Web\Controller;

use Core\Controller;

use Lib\Memcached;

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
        $memcached = new Memcached;

        $modulesData = $memcached->get('Module::getAll');

        if ( $modulesData === false ) {
            $modulesData = Module::getAll();

            $memcached->set('Module::getAll', $modulesData);
        }

        $this->view->assign([ 
            'title' => 'Weather Dashboard',
            'modules' => $modulesData
        ]);

        return true;
    }
}
