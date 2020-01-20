<?php
namespace App;

use Doctrine\Common\Cache\Cache;

class DoctrineCacheAdapter implements CacheInterface
{

    private $doctrineCache;

    public function __construct(Cache $doctrineCache)
    {
        $this->doctrineCache = $doctrineCache;
    }

    public function get($key)
    {
        return $this->doctrineCache->fetch($key);
    }

    public function has($key)
    {
        return $this->doctrineCache->contains($key);
    }

    public function set($key, $value, $expiration = 3600)
    {
        $this->doctrineCache->save($key, $value, $expiration);
    }
}
