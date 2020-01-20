<?php

use App\Dispatcher;
use App\PoweredByMiddleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function Http\Response\send;

require __DIR__ . '/vendor/autoload.php';

define('BASE_URI', '/MIDDLEWARE');

/* TEST DE CALLABLE */

/* DEFINITION  */

/* $func = function (string $name, callable $next) {
    echo "Bonjour Mr " . $name;
    return call_user_func($next);
}; */

/* EXECUTION */

/* $res = $func('Oualid Lahsni', function () {
    return ", C'est un bon jour !";
});

echo $res; */

/* function m($number = 0, callable $callback)
{
    $number = $number * 10;

    return call_user_func($callback, $number);
}
function callableFunction($number)
{
    return "The Number is $number";
}
echo m(4, 'callableFunction');


die; */


$removeSlashMiddelWare = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
    $url = (string)$request->getUri()->getPath();
    if (!empty($url) && $url[-1] === '/') {

        return $response
            ->withHeader('Location', substr($url, 0, -1))
            ->withStatus(301);
    }

    return $next($request, $response);
};
$quoteMiddleWare = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {

    $response->getBody()->write('"');
    $response = $next($request, $response);
    $response->getBody()->write('"');

    return $response;
};
$app = function (ServerRequestInterface $request, ResponseInterface $response) {

    $url = $request->getUri()->getPath();
    if ($url === BASE_URI . '/blog') {
        $response->getBody()->write("Je suis sur le blog");
    } elseif ($url === BASE_URI . '/contact') {
        $response->getBody()->write("Me contacter");
    } else {
        $response->getBody()->write("Not Found");
        $response = $response->withStatus(404);
    }

    return $response;
};


$request = ServerRequest::fromGlobals();
$response = new Response();


/* 
$response = $removeSlashMiddelWare($request, $response, function ($request, $response) use ($quoteMiddleWare, $app) {

    return $quoteMiddleWare($request, $response, function ($request, $response) use ($app) {
        return $app($request, $response);
    });
});


send($response); */


$dispatcher = new Dispatcher();
$dispatcher->pipe(new PoweredByMiddleware());
$dispatcher->pipe($removeSlashMiddelWare);
$dispatcher->pipe($quoteMiddleWare);
$dispatcher->pipe($app);


send($dispatcher->handle($request));
