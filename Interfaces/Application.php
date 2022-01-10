<?php namespace Interfaces;

interface Application
{
    public function initModules(): bool;
    public function run(ApplicationRequest $request): bool;
    public function terminate(): void;
}
