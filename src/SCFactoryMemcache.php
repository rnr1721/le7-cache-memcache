<?php

declare(strict_types=1);

namespace Core\Cache;

use Psr\SimpleCache\CacheInterface;
use Core\Cache\Adapters\CacheMemcacheAdapter;
use Core\Cache\Adapters\CacheMemcachedAdapter;
use \Memcache;
use \Memcached;

class SCFactoryMemcache
{

    public function getMemcache(string $host = "127.0.0.1", int $port = 11211): CacheInterface
    {
        $memcache = new Memcache;
        $memcache->connect($host, $port) or die('SCFactory::getMemcache() Could not connect');
        $adapter = new CacheMemcacheAdapter($memcache);
        return new SimpleCache($adapter);
    }

    public function getMemcached(string $host = "127.0.0.1", int $port = 11211): CacheInterface
    {
        $memcached = new Memcached;
        $memcached->addServer($host, $port);
        $adapter = new CacheMemcachedAdapter($memcached);
        return new SimpleCache($adapter);
    }

}
