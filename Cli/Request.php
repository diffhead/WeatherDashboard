<?php namespace Cli;

use Interfaces\ApplicationRequest;

class Request implements ApplicationRequest
{
    public function setRequestData(array $requestData): bool
    {
        return true;
    }

    public function getRequestData(): array
    {
        return [];
    }
}
