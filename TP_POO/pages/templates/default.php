<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">

    <title><?= App\App::getInstance()->getTitle() ?></title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="padding-top: 100px">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Mon Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="?p=home">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?p=single">Single</a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container jumbotron">

        <div class="starter-template">

            <?= $content ?>

        </div>

    </main><!-- /.container -->

</body>

</html>