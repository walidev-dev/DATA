<?php

namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    public function get(string $path, $callable, string $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    public function match(ServerRequestInterface $request): ?Route
    {
        $routeResult = $this->router->match($request);
        if ($routeResult->isSuccess()) {
            return new Route(
                $routeResult->getMatchedRouteName(),
                $routeResult->getMatchedMiddleware(),
                $routeResult->getMatchedParams()
            );
        }
        return null;
    }

    public function generateUri(string $name, array $params = [],array $queryArgs = []): string
    {
        $uri = $this->router->generateUri($name, $params);
        if(!empty($queryArgs)){
            return $uri.'?'.http_build_query($queryArgs);
        }
        return $uri;
    }
}
