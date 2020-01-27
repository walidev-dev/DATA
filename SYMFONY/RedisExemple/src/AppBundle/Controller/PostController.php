<?php

namespace AppBundle\Controller;

use AppBundle\Cache\RedisDoctrineCache;
use AppBundle\Cache\RedisPoolCache;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller
{
    public function indexAction(RedisDoctrineCache $cache)
    {
        $key = 'posts';
        if (!$cache->has($key)) {
            $cache->set($key,  $this->get('doctrine')->getRepository(Post::class)->getAll());
        }
        return $this->render('default/index.html.twig', array('posts' => $cache->get($key)));
    }
}
