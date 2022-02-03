<?php namespace Interfaces;

interface ControllerOutput 
{
    public function setCode(int $code): void;
    public function setData(array $data): void;

    public function getCode(): int;
    public function getData(): array;
}
