<?php namespace Interfaces\Web;

interface HttpRequest 
{
    public function __construct( string $url, string $method = 'GET', array $headers = [], array $cookies = [], string|array $data = [] );

    public function getUrl(): string;
    public function getMethod(): string;
    public function getHeaders(): array;
    public function getCookies(): array;
    public function getData(): string|array;
}
