<?php

namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $this->router->get('/blog', function () {
            return 'hello';
        }, 'blog');
        $fakeRequest = new ServerRequest('GET', '/blog');
        $route = $this->router->match($fakeRequest);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallBack(), [$fakeRequest]));
    }

    public function testGetMethodIfURLDoesNotExists()
    {
        $this->router->get('/blog', function () {
            return 'hello';
        }, 'blog');
        $request = new ServerRequest('GET', '/blogsas');
        $route = $this->router->match($request);
        $this->assertNull($route);
    }

    public function testGetMethodWithParameters()
    {
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:[\d+]}', function () {
            return 'hello';
        }, 'post.show');
        $request = new ServerRequest('GET', '/blog/mon-slug-8');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals(['slug' => 'mon-slug', 'id' => '8'], $route->getParameters());
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:[\d+]}', function () {
            return 'hello';
        }, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' =>'mon-article','id' =>18]);
        $this->assertEquals('/blog/mon-article-18', $uri);
    }

    public function testGenerateUriWithParams()
    {
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:[\d+]}', function () {
            return 'hello';
        }, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' =>'mon-article','id' =>18],['p' => 2]);
        $this->assertEquals('/blog/mon-article-18?p=2', $uri);
    }
}
