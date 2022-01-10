<?php namespace Interfaces\Web;

interface HttpResponse
{
    public function __construct(int $code, string|array $data = [], array $headers = [], array $cookies = [], bool $status = false);

    public function getCode(): int;
    public function getData(): string|array;
    public function getStatus(): bool;
    public function getHeaders(): array;
    public function getCookies(): array;
}
