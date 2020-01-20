<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__) . DS);
require ROOT.'vendor/autoload.php';

use function Http\Response\send;
use App\Blog\BlogModule;

$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
$whoops->register();

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(ROOT.'config/config.php');
$container = $builder->build();

$app = new \Framework\App($container, [
    BlogModule::class
]);

$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

send($response);
