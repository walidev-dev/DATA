<?php

namespace App;


use Interop\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PoweredByMiddleware implements MiddlewareInterface
{
    /* public function __invoke($request, $response, $next)
    {
        $response = $response->withHeader('X-Powered-By', 'Grafikart');
        return call_user_func($next, $request, $response);
    } */

    public function process(ServerRequestInterface $request, RequestHandlerInterface $requestHandler): ResponseInterface
    {
        $response = $requestHandler->handle($request);
        $response = $response->withHeader('X-Powered-By', 'Grafikart');
        return $response;
    }
}
