<?php

namespace App;

class Hello
{
    public function sayHello(CacheInterface $cache)
    {
        if ($cache->has('hello')) {
            return $cache->get('hello');
        } else {
            sleep(4);
            $cache->set('hello', 'Bonjour', 3600);
            return $cache->get('hello');
        }
    }
}
