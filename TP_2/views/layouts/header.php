<?php

use App\Session;


?>
<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $title ?? 'Mon Site'; ?></title>
</head>

<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="<?= $router->url('home') ?>" class="navbar-brand">Mon Site</a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?= $router->currentUrlName() === 'admin_posts' ? 'active' : ''  ?>">
                <a class="nav-link" href="<?= $router->url('admin_posts') ?>">Articles</a>
            </li>
            <li class="nav-item <?= $router->currentUrlName() === 'admin_categories' ? ' active' : ''  ?>">
                <a class="nav-link" href="<?= $router->url('admin_categories') ?>">Catégories</a>
            </li>
        </ul>
        <a href="<?= $router->url('logout') ?>" class="btn btn-dark">Se déconnecter</a>
    </nav>
    <div class="container pt-4">

        <?php if (Session::hasFlash('danger')) : ?>
            <div class="alert alert-danger">
                <?= Session::getFlash('danger'); ?>
            </div>
        <?php endif ?>