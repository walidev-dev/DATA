<?php

namespace Tests\Blog\Actions;

use App\Blog\Actions\BlocAction;
use App\Blog\Entities\Post;
use App\Blog\Tables\PostTable;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class BlogActionTest extends TestCase
{

    /**
     * @var BlocAction
     */
    private $action;
    private $postTable;
    private $router;
    private $renderer;

    public function setUp()
    {
        $this->postTable = $this->getMockBuilder(PostTable::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->renderer = $this->getMockBuilder(RendererInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->renderer
            ->method('render')
            ->willReturn('');

        $this->router = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->action = new BlocAction($this->renderer, $this->router, $this->postTable);

    }

    public function makePost($id, $slug)
    {
        return (new Post())
            ->setId($id)
            ->setSlug($slug);
    }

    public function testShowRedirect()
    {
        $post = $this->makePost(9, 'demo-test');
        $this->postTable
            ->method('getOne')
            ->willReturn($post);

        $this->router
            ->method('generateUri')
            ->willReturn('blog/demo-test-9');

        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', 9)
            ->withAttribute('slug', 'demo');

        $response = $this->action->show($request);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals(['blog/demo-test-9'], $response->getHeader('Location'));
    }


    public function testShowRender()
    {
        $post = $this->makePost(9, 'demo');
        $this->postTable
            ->method('getOne')
            ->willReturn($post);

        $this->router
            ->method('generateUri')
            ->willReturn('blog/demo');

        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', 9)
            ->withAttribute('slug', 'demo');

        $response = $this->action->show($request);
        $this->assertEquals(true,true);
    }
}