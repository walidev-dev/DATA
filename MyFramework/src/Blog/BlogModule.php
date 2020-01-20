<?php

namespace App\Blog;

use App\Blog\Actions\BlocAction;
use Framework\Router;
use Framework\Renderer\RendererInterface;

class BlogModule
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    public function __construct(Router $router, RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('blog', __DIR__ . DIRECTORY_SEPARATOR . 'views');
        $router->get('/blog', BlocAction::class, 'blog_index');
        $router->get('/blog/{slug:[a-z\-]+}-{id:\d+}', BlocAction::class, 'blog_show');
    }








    /*public function index(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@blog/index');
    }

    public function show(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@blog/show', [
            'slug' => $request->getAttribute('slug'),
            'id' => $request->getAttribute('id')
        ]);
    }*/
}
