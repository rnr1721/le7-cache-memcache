<?php

namespace Core\Interfaces;

use Psr\SimpleCache\CacheInterface;

interface SCFactoryMemcache extends SCFactory
{

    /**
     * Get memcache instance of SimpleCache
     * @param string $host Memcache host
     * @param int $port Memcache port
     * @return CacheInterface
     */
    public function getMemcache(string $host = "127.0.0.1", int $port = 11211): CacheInterface;

    /**
     * Get memcached instance of SimpleCache
     * @param string $host Memcached host
     * @param int $port Memcached port
     * @return CacheInterface
     */
    public function getMemcached(string $host = "127.0.0.1", int $port = 11211): CacheInterface;
}
