<?php

declare(strict_types=1);

namespace App\Cache\Adapters;

use App\Cache\SCAdapterInterface;
use App\Cache\SCAdapterTrait;
use \Memcached;
use \DateInterval;
use function boolval;

class CacheMemcachedAdapter implements SCAdapterInterface
{

    use SCAdapterTrait;

    private Memcached $mc;

    public function __construct(Memcached $memcached)
    {
        $this->mc = $memcached;
    }

    public function clear(): bool
    {
        return $this->mc->flush();
    }

    public function delete(string $key): bool
    {
        return $this->mc->delete($key);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $result = $this->mc->get($key);
        if ($result === false) {
            return $default;
        }
        return $result;
    }

    public function has(string $key): bool
    {
        $result = $this->mc->get($key);
        if ($result === false) {
            return false;
        }
        return true;
    }

    public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool
    {
        $ttlFinal = $this->processTTL($ttl);
        if (!$ttlFinal) {
            $ttlFinal = 0;
        }
        return $this->mc->set($key, $value, $ttlFinal);
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {

        $data = array();

        $result = $this->mc->getMulti((array)$keys);

        foreach ($keys as $key) {
            $data[$key] = $result[$key] ?? $default;
        }

        return $data;
    }

    public function setMultiple(iterable $values, null|int|DateInterval $ttl = null): bool
    {
        $ttlFinal = $this->processTTL($ttl);
        if ($ttlFinal === null) {
            $ttlFinal = 0;
        }
        return $this->mc->setMulti((array) $values, $ttlFinal);
    }

    public function deleteMultiple(iterable $keys): bool
    {
        $data = $this->mc->deleteMulti((array) $keys);
        $result = true;
        foreach ($data as $item) {
            $current = boolval($item);
            if (!$current) {
                $result = false;
            }
        }
        return $result;
    }

}
