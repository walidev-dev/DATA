<?php

namespace Framework;

use Framework\Renderer\RendererInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

    private $modules = [];

    /**
     * App constructor.
     * @param ContainerInterface $container
     * @param array $modules
     */
    public function __construct(ContainerInterface $container, array $modules = [])
    {
        $this->container = $container;
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
        /* if ($container->has(RendererInterface::class)) {
             $container->get(RendererInterface::class)->addGlobal('router', $this->container->get(Router::class));
         }*/
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === '/') {
            return new Response(301, ['Location' => substr($uri, 0, -1)]);
        }

        $route = $this->container->get(Router::class)->match($request);
        if (is_null($route)) {
            return new Response(404, [], '<h1>Erreur 404</h1>');
        }

        foreach ($route->getParameters() as $k => $v) {
            $request = $request->withAttribute($k, $v);
        }

        $response = call_user_func_array($this->container->get($route->getCallBack()), [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('The Response is not a string or an instance of ResponseInterface');
        }
    }
}
