<?php namespace Cli;

use Interfaces\ApplicationRequest;
use Interfaces\Application as ApplicationInterface;

class Application implements ApplicationInterface
{
    public function initModules(): bool
    {
        return true;
    }

    public function run(ApplicationRequest $request): bool
    {
        return true;
    }
}
