<?php namespace Views;

use Core\View;

use Services\JsonService;
use Services\StringService;

class Json extends View
{
    private bool $needToRebuildString = true;

    public function __construct(array $params = [])
    {
        $this->assign($params);
        $this->render();
    }

    public function assign(array $params): void
    {
        $this->needToRebuildString = true;

        parent::assign($params);
    }

    public function render(): string
    {
        if ( $this->needToRebuildString || StringService::isEmpty($this->template) ) {
            $this->template = JsonService::encode($this->params);
        }

        return $this->template;
    }
}
