<?php namespace Modules\ModulesHandler\Controller;

use Core\Controller;

use Views\Json as JsonView;

class Create extends Controller
{
    public function init(): void
    {
        $this->view = new JsonView([ 'status' => true ]);
    }

    public function execute(array $params = []): bool
    {
        return true;
    }
}
