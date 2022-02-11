<?php namespace Core;

use Interfaces\View as ViewInterface;

use Lib\Twig;

use Services\ArrayService;
use Services\FileService;
use Services\StringService;

class View implements ViewInterface
{
    protected array  $params = [];
    protected string $template = '';
    protected bool   $templateIsFile = false;

    protected Twig $twig;

    public function __construct()
    {
        if ( $this->templateIsFile && FileService::fileExists(_APP_BASE_DIR_ . $this->template) ) {
            $templatePath = FileService::getDir(_APP_BASE_DIR_ . $this->template) . '/';
            $templateFile = StringService::strReplace(_APP_BASE_DIR_ . $this->template, $templatePath, '');

            $this->twig = new Twig($templatePath);
            $this->template = $templateFile;
        }
    }

    public function assign(array $params): void
    {
        $this->params = ArrayService::merge($this->params, $params);
    }

    public function render(): string
    {
        if ( $this->templateIsFile && $this->twig ) {
            return $this->twig->render($this->template, $this->params);
        }

        return $this->template;
    }

    public function display(): void
    {
        echo $this->render();
    }
}
