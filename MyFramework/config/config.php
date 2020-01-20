<?php
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Router;
use Psr\Container\ContainerInterface;
use App\Blog\Actions\BlocAction;
use App\Blog\BlogModule;
use function DI\get;
use function DI\object;

return [
    'views_path' => ROOT . 'src/templates/',
    Twig_Loader_Filesystem::class => object()->constructor(get('views_path')),
    Twig_Environment::class => object()->constructor(get(Twig_Loader_Filesystem::class)),
    RendererInterface::class => object(TwigRenderer::class)
        ->constructor(
            get(Twig_Loader_Filesystem::class),
            get(Twig_Environment::class)
        ),
    Router::class => object(),
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'db_myframework',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => 'root',
    PDO::class => function (ContainerInterface $container) {
        return new PDO('mysql:host=' . $container->get('DB_HOST') . ';dbname=' . $container->get('DB_NAME'),
            $container->get('DB_USERNAME'),
            $container->get('DB_PASSWORD'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }


    //BlocAction::class => object()->constructor(get(RendererInterface::class),get(\PDO::class))
    // BlogModule::class => object()->constructor(get(Router::class), get(RendererInterface::class))


];