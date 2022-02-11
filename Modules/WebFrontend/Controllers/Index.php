<?php namespace Modules\WebFrontend\Controllers;

use Core\Cache;
use Core\Controller;

use Models\Module;

use Modules\WebFrontend\Views\Index as IndexView;

class Index extends Controller
{
    public function init(): void
    {
        $this->view = new IndexView;
    }

    public function execute(array $params = []): bool
    {
        $cache = new Cache('modules.all', 3600, Cache::MEM);

        $modules = $cache->getData();

        if ( $modules === false ) {
            $modules = Module::getAll();

            $cache->setData($modules);
        }

        $this->view->assign([
            'title' => 'Weather Dashboard',
            'modules' => $modules
        ]);

        return true;
    }
}
