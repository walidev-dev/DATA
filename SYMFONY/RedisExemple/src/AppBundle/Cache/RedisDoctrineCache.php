<?php

namespace AppBundle\Cache;


use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\RedisCache;

class RedisDoctrineCache implements CacheInterface
{
    /**
     * @var Cache
     */
    private $cache = null;

    public function __construct()
    {
        if(is_null($this->cache))
        {
            $redis = new \Redis();
            $redis->connect('127.0.0.1', 6379);

            $this->cache = new RedisCache();
            $this->cache->setRedis($redis);
        }

    }

    public function get($key)
    {
        return $this->cache->fetch($key);
    }

    public function has($key)
    {
        return $this->cache->contains($key);
    }

    public function set($key, $value, $expire = 3600)
    {
        $this->cache->save($key, $value, $expire);
    }
}