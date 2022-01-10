<?php namespace Interfaces\Web;

interface HttpHeader
{
    public function __construct(string $name, string $value, bool $replace = true);
    public function getRaw(): string;
    public function getName(): string;
    public function getValue(): string;
    public function isForReplace(): bool;
}
