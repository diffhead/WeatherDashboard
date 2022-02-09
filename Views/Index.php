<?php namespace Views;

use Core\View;

use Services\ArrayService;

class Index extends View
{
    protected string $template = _APP_BASE_DIR_ . 'Templates/index.tpl';
    protected bool   $templateIsFile = true;

    public function render(): string
    {
        return $this->template;
    }
}
