<?php namespace Interfaces;

interface Application
{
    const WEB_ENVIRONMENT = 1;
    const CLI_ENVIRONMENT = 2;

    public function initModules(): bool;
    public function run(ApplicationRequest $request): bool;
}
