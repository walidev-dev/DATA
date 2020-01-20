<?php

namespace App;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Dispatcher implements RequestHandlerInterface
{
    /**
     * @var int
     */
    private $index = 0;

    /**
     * @var array
     */
    private $middlewares = [];

    /**
     * @var Response
     */
    private $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    /**
     * @param callable|MiddlewareInterface $middleware
     */
    public function pipe($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->getMiddleware();
        $this->index++;
        if ($middleware === null) {
            return $this->response;
        }
        if (is_callable($middleware)) {
            return $middleware($request, $this->response, [$this, 'handle']);
        } elseif ($middleware instanceof MiddlewareInterface) {
            return $middleware->process($request, $this);
        }
    }

    public function getMiddleware()
    {
        if (isset($this->middlewares[$this->index])) {
            return $this->middlewares[$this->index];
        }
        return null;
    }
}
