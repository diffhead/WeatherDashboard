<?php namespace Views;

use Interfaces\View;

use Services\ArrayService;

class Index implements View
{
    private string $content = '<h1>Hello world</h1>';
    private array  $data = [];

    public function assign(array $data = []): void
    {
        $this->data = ArrayService::merge($this->data, $data);
    }

    public function render(): string
    {
        return $this->content;
    }

    public function display(): void
    {
        echo $this->render();
    }
}
