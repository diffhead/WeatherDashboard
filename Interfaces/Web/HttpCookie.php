<?php namespace Interfaces\Web;

interface HttpCookie
{
    public function __construct(
        string $name, 
        string $value, 
        int $expires = -1,
        string $path = '',
        string $domain = '',
        bool $secure = true,
        bool $httpOnly = true
    );

    public function getName(): string;
    public function getValue(): string;
    public function getExpires(): int;
    public function getExpiresRFC(): string;
    public function getPath(): string;
    public function getDomain(): string;
    public function getSecure(): bool;
    public function getHttpOnly(): bool;
}
