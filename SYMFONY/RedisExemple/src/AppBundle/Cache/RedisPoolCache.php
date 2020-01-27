<?php

namespace AppBundle\Cache;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Symfony\Component\Cache\CacheItem;

class RedisPoolCache implements CacheInterface
{

    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    public function get($key)
    {
        return $this->cache->getItem($key)->get();
    }

    public function set($key, $value, $expire = null)
    {
        $cachedItem = $this->cache->getItem($key);
        $cachedItem->set($value);
        $this->cache->save($cachedItem);
    }

    public function has($key)
    {
        return $this->cache->getItem($key)->isHit();
    }
}