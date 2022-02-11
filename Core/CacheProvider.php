<?php namespace Core;

class CacheProvider
{
    public function __construct(int $type = Cache::MEM)
    {
    }

    public function setValue(string $key, mixed $value): bool
    {
        return true;
    }

    public function getValue(string $key): mixed
    {
        return _APP_EMPTY_STRING_;
    }
}
