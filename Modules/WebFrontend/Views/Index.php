<?php namespace Modules\WebFrontend\Views;

use Core\View;

class Index extends View
{
    protected string $template = _MODULES_DIR_ . 'WebFrontend/templates/index.tpl';
    protected bool   $templateIsFile = true;
}
