<?php namespace Modules\AuthModule\Controller;

use Core\Controller;

use Views\Json as JsonView;

class Login extends Controller
{
    public function init(): void
    {
        $this->view = new JsonView([ 'status' => false ]);
    }
    
    public function execute(array $params = []): bool
    {
        return true;
    }
}
