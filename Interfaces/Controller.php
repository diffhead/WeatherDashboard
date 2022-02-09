<?php namespace Interfaces;

interface Controller
{
    public function init(): void;
    public function execute(array $params = []): bool;
    public function getView(): View;
}
