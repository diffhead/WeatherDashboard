<?php namespace Interfaces;

interface View
{
    public function assign(array $params): void;
    public function render(): string;
    public function display(): void;
}
