<?php

namespace Framework\Renderer;

use Framework\Router;
use Framework\TwigExtension\GenerateUriExtension;
use Framework\TwigExtension\PagerFantaExtension;
use Framework\TwigExtension\TextExtension;
use Framework\TwigExtension\TimeExtension;
use Psr\Container\ContainerInterface;

class TwigRenderer implements RendererInterface
{
    /**
     * @var \Twig_Loader_Filesystem
     */
    private $loader;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(
        \Twig_Loader_Filesystem $twig_Loader_Filesystem,
        \Twig_Environment $twig_Environment,
        ContainerInterface $container
    )
    {


        $this->loader = $twig_Loader_Filesystem;
        $this->twig = $twig_Environment;
        $this->twig->addExtension($container->get(GenerateUriExtension::class));
        $this->twig->addExtension($container->get(PagerFantaExtension::class));
        $this->twig->addExtension($container->get(TextExtension::class));
        $this->twig->addExtension($container->get(TimeExtension::class));
    }

    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    public function render(string $view, ?array $params = []): string
    {
        return $this->twig->render($view . '.twig', $params);
    }

    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
