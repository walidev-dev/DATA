<?php
namespace App;

interface CacheInterface
{

    public function get($key);

    public function has($key);

    public function set($key, $value, $expiration);
}
