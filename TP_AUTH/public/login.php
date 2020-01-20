<?php
require_once '../vendor/autoload.php';

use App\App;

session_start();

if (App::getAuth()->user() && isset($_GET['forbid']) && (int) $_GET['forbid'] !== 1) {
    header('Location: index.php?login=1');
    exit;
}

$error = false;

if (!empty($_POST)) {
    if (App::getAuth()->login($_POST['username'], $_POST['password'])) {
        header('Location: index.php?login=1');
        exit;
    }
    $error = true;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Page de Connexion</title>
</head>

<body class="p-4">
    <div class="container jumbotron">
        <h2>Se Connecter</h2>
        <?php if ($error) : ?>
            <div class="alert alert-danger">
                Identifiant ou Mot de passe sont incorrectes
            </div>
        <?php endif ?>
        <?php if (isset($_GET['forbid'])) : ?>
            <div class="alert alert-danger">
                L'accés à la page est interdit
            </div>
        <?php endif ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Pseudo">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe">
            </div>
            <button class="btn btn-primary" type="submit">Se Connecter</button>
        </form>
    </div>
</body>

</html>