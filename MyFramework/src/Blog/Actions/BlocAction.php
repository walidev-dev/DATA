<?php

namespace App\Blog\Actions;

use App\Blog\Tables\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\Request;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Psr\Http\Message\ServerRequestInterface;

class BlocAction
{
    private $renderer;
    private $router;
    private $postTable;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        }
        return $this->index($request);
    }

    public function index(ServerRequestInterface $request): string
    {
        $params = $request->getQueryParams();
        $posts = $this->postTable->getAll();
        $adapter = new ArrayAdapter($posts);
        $pagerFanta = (new Pagerfanta($adapter))
            ->setMaxPerPage(12)
            ->setCurrentPage($params['p'] ?? 1);
        return $this->renderer->render('@blog/index', [
            'pagerFanta' => $pagerFanta
        ]);
    }

    public function show(ServerRequestInterface $request)
    {
        $post = $this->postTable->getOne($request->getAttribute('id'));
        if ($post->getSlug() !== $request->getAttribute('slug')) {
            return $this->redirect('blog_show', ['slug' => $post->getSlug(), 'id' => $post->getId()]);
        }
        return $this->renderer->render('@blog/show', compact('post'));
    }
}
