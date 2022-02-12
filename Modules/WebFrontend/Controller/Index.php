<?php namespace Modules\WebFrontend\Controller;

use Core\Cache;
use Core\Context;
use Core\Controller;

use Modules\WebFrontend\Views\Index as IndexView;

use Core\GlobalConfig;

class Index extends Controller
{
    public function init(): void
    {
        $this->view = new IndexView;
    }

    public function execute(array $params = []): bool
    {
        $this->view->assign([
            'title' => 'Weather Dashboard'
        ]);

        return true;
    }
}
