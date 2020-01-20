<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <title><?php if (isset($title)) {
        echo $title;
           } else {
    echo 'Accueil';
}?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a href="#" class="navbar-brand">Mon Blog</a>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
            <a class="nav-link" href="#">Accueil</a>
        </li>
    </ul>
    <a href="#" class="btn btn-dark">Se déconnecter</a>
</nav>
<div class="container mt-4">


