<?php namespace Core;

use Core\Database\Db;
use Core\Database\Query;

class Cache
{
    const DB = 1;
    const MEM = 2;
    const FILE = 3;

    private string $key = '';
    private int    $type = Cache::MEM;
    private int    $expiration;

    private CacheProvider $cacheProvider;

    public function __construct(string $key, int $expiration = 3600, int $type = Cache::MEM)
    {
        $this->key = $key;
        $this->type = $type;
        $this->expiration = $expiration;
        $this->cacheProvider = new CacheProvider($type);
    }

    public function getValue(): mixed
    {
        $this->cacheProvider->getValue($this->key);
    }

    public function setValue(mixed $value): bool
    {
        $this->cacheProvider->setValue($this->key, $value);
    }
}
