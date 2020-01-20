<?php
require 'vendor/autoload.php';
$page = $_GET['p'] ?? 'home';
$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader,[
    'cache' => false
]);
function tutoriels()
{
    $pdo = new PDO('mysql:host=localhost;dbname=blog','root','root',[
       PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_OBJ
    ]);
    return $pdo->query("SELECT id,name from post order by created_at DESC limit 10")->fetchAll();
}

switch ($page){
    case 'home':
        echo $twig->render('home.twig',['tutoriels' => tutoriels()]);
        break;
    case 'contact':
        echo $twig->render('contact.twig');
        break;
    default:
        header('HTTP/1.0 404 Not Found');
}