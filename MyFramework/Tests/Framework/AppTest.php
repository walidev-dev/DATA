<?php

namespace Tests\Framework;

//define('DS',DIRECTORY_SEPARATOR);
//define('ROOT','/var/www/html/MyFramework/');
use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
//    public function testRedirectTrailingSlash()
//    {
//        $app = new App();
//        $request = new ServerRequest('GET', '/demoslash/');
//        $response = $app->run($request);
//        $this->assertContains('/demoslash', $response->getHeader('Location'));
//        $this->assertEquals(301, $response->getStatusCode());
//    }

//    public function testBlog()
//    {
//        $app = new App([
//            BlogModule::class
//        ]);
//        $request = new ServerRequest('GET', '/blog');
//        $response = $app->run($request);
//        $this->assertContains('<h1>Bienvenu sur le blog</h1>', (string)$response->getBody());
//        $this->assertEquals(200, $response->getStatusCode());
//    }
}
