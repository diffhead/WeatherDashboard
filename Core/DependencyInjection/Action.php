<?php namespace Core\DependencyInjection;

class Action
{
    public const SEND_STATIC_VALUE = 'static-value';
    public const CALL_STATIC_METHOD = 'static-method';

    private string $type;
    private string $value;
    private array  $args;

    public function __construct(string $type, string $value, array $args = [])
    {
        $this->type = $type;
        $this->value = $value;
        $this->args = $args;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getArgs(): array
    {
        return $this->args;
    }
}
