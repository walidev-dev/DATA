<?php

namespace Framework\TwigExtension;

use Framework\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GenerateUriExtension extends AbstractExtension
{
    /**
     * @var Router $router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function pathFor(string $name, array $params = [])
    {
        return $this->router->generateUri($name, $params);
    }

    public function getFunctions()
    {
        return [ new TwigFunction('path', [$this, 'pathFor']) ];
    }
}
