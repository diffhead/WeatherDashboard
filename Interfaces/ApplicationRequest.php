<?php namespace Interfaces;

interface ApplicationRequest 
{
    public function setRequestData(array $requestData): void;
    public function getRequestData(): array;
}
