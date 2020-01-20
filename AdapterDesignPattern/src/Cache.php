<?php

namespace App;

class Cache implements CacheInterface
{
    public function get($key)
    {
        return false;
    }

    public function has($key)
    {
        return false;
    }

    public function set($key, $value, $expiration = 3600)
    {
        return false;
    }
}
