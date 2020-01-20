<?php
require 'vendor/autoload.php';

use App\DoctrineCacheAdapter;
use App\Hello;
use Doctrine\Common\Cache\FilesystemCache;

//$cache = new FilesystemCache(__DIR__ . '/cache');

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$cacheDriver = new \Doctrine\Common\Cache\RedisCache();
$cacheDriver->setRedis($redis);
$adapter = new DoctrineCacheAdapter($cacheDriver);
$hello = new Hello();
echo $hello->sayHello($adapter);
