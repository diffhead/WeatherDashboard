<?php namespace Core;

use Services\StringService;

class Route
{
    const TYPE_RAW = 1;
    const TYPE_REGEX = 2;

    private int    $type;
    private string $route;
    private array  $params;
    private bool   $protected;
    private string $controller;

    public function __construct(string $route, int $type, string $controller, array $params = [], bool $protected = true)
    {
        $this->route = $route;
        $this->type = $type;
        $this->controller = $controller;
        $this->params = $params;
        $this->protected = $protected;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function isCurrentRoute(string $stringPattern): bool
    {
        if ( $this->type === self::TYPE_REGEX ) {
            return (bool)preg_match($this->getRoute(), $stringPattern);
        }

        return $stringPattern === $this->getRoute();
    }

    public function isProtected(): bool
    {
        return $this->protected;
    }
}
