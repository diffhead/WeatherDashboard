<?php namespace Modules\CacheHandler\Controller;

use Core\Controller;
use Views\Json as JsonView;

class Cache extends Controller
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
