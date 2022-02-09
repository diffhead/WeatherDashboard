<?php namespace Core;

use Interfaces\View as ViewInterface;

use Services\ArrayService;

class View implements ViewInterface
{
    protected array  $params = [];
    protected string $template = '';
    protected bool   $templateIsFile = false;

    public function __construct()
    {
        if ( $this->templateIsFile ) {
            $templateFile = new FileStream($this->template);

            if ( $templateFile->open() ) {
                $this->template = $templateFile->read();
            }
        }
    }

    public function assign(array $params): void
    {
        $this->params = ArrayService::merge($this->params, $params);
    }

    public function render(): string
    {
        return $this->template;
    }

    public function display(): void
    {
        echo $this->render();
    }
}
