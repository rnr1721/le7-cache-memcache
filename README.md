# Memcache and memcached apapters for rnr1721/le7-cache

It make enable to use memcache or memcached with le7-framework or any PHP project

## Requirements

- PHP 8.1 or higher.
- Composer 2.0 or higher.

## What it can?

- Standard implementation of PSR-16 Simple Cache
- Out of the box can use Filesystem, memory and session adapters
- Use memcache and memcached for caching

## Installation

```shell
composer require rnr1721/le7-cache-memcache
```

## Testing

```shell
composer test
```

## How it works?

```php

use Core\Cache\SCFactoryMemcacheGeneric;

$cacheFactory = new SCFactoryMemcacheGeneric();

// For memcache
$cache = $cacheFactory->getMemcache("127.0.0.1", 11211);
// For memcached
$cache = $cacheFactory->getMemcached("127.0.0.1", 11211);

$data = [
    'value1' => 'The 1 value',
    'value2' => 'The 2 value'
    ];

// Put data in cache
// Set cache key, value and time-to-live
$cache->set('mykey', $data, 5000);

// Get value from cache
$result = $cache->get('mykey');

print_r($result);

```

## implemented methods

```php

use Psr\SimpleCache\CacheInterface;

    public function get(string $key, mixed $default = null): mixed;

    public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool;

    public function delete(string $key): bool;

    public function clear(): bool;

    public function getMultiple(iterable $keys, mixed $default = null): iterable;

    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool;

    public function deleteMultiple(iterable $keys): bool;

    public function has(string $key): bool;

```

## factory methods

```php

use Core\Cache\Interfaces\SCFactoryMemcache;

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

```
