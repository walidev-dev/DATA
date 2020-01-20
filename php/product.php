<?php
require_once 'vendor/autoload.php';

use App\Connexion;
use App\NumberHelper;
use App\TableHelper;
use App\URLHelper;

define('PER_PAGE', 20);

$pdo = Connexion::getPDO();
$query = "SELECT *FROM products";
$queryCount = "SELECT COUNT(id) as count FROM products";
$sortable = ['id', 'name', 'address', 'price', 'city'];

/*       RECHERCHE PAR VILLE        */

$params = [];
if (isset($_GET['q']) && strlen(trim($_GET['q'])) > 0) {
    $q = trim($_GET['q']);
    $query .= " WHERE city LIKE :city";
    $queryCount .= " WHERE city LIKE :city ";
    $params = ['city' => '%' . $q . '%'];
}

/*         ORGANISATION          */

if (!empty($_GET['sort']) && in_array($_GET['sort'], $sortable)) {
    $direction = $_GET['dir'] ?? 'asc';
    if (!in_array($direction, ['asc', 'desc'])) {
        $direction = 'asc';
    }
    $query .= " ORDER BY " . $_GET['sort'] . " " . $direction;
}





/*       PAGINATION       */

$page = (int) ($_GET['p'] ?? 1);
$offset = ($page - 1) * PER_PAGE;

$queryCount = $pdo->prepare($queryCount);
$queryCount->execute($params);
$productsCount = (int) $queryCount->fetch()->count;
$PagesCount = (int) ceil($productsCount / PER_PAGE);

/* REQUETE POUR AVOIR LES RESULTATS */

/* $query .= " LIMIT " . PER_PAGE . " OFFSET " . $offset; */

$query .= " LIMIT :limit OFFSET :offset";
$params_2 = [
    'limit' => PER_PAGE,
    'offset' => $offset
];

$params = array_merge($params, $params_2);
$statement = $pdo->prepare($query);
$statement->execute($params);
$products = $statement->fetchAll();





?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style>
        th {
            color: rgba(0, 38, 255, 0.89);
        }
    </style>
    <title>Biens Immobiliers</title>
</head>

<body>
    <div class=" container-fluid">
        <h2> Tous les biens </h2>
        <form action="">
            <div class="form-group">
                <input type="text" name="q" placeholder="Rechercher par ville" class="form-control" value="<?= (!empty($_GET['q'])) ? htmlentities($_GET['q']) : null ?>">
            </div>
            <button class="btn btn-primary">Rechercher</button>
        </form>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?= TableHelper::sort('id', 'ID', $_GET) ?></th>
                    <th><?= TableHelper::sort('name', 'Nom', $_GET) ?></th>
                    <th><?= TableHelper::sort('price', 'Prix', $_GET) ?></th>
                    <th><?= TableHelper::sort('city', 'Ville', $_GET) ?></th>
                    <th><?= TableHelper::sort('address', 'Adresse', $_GET) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                <tr>
                    <td>#<?= $product->id ?></td>
                    <td><?= $product->name ?></td>
                    <td><?= NumberHelper::price($product->price) ?></td>
                    <td><?= $product->city ?></td>
                    <td><?= $product->address ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php if ($PagesCount > 1 && $page <= $PagesCount && $page >= 2) : ?>
        <a href="?<?= URLHelper::withParam($_GET, "p", $page - 1) ?>" class="btn btn-primary">Page Précédente</a>
        <?php endif ?>
        <?php if ($PagesCount > 1 && $page < $PagesCount) : ?>
        <a href="?<?= URLHelper::withParam($_GET, "p", $page + 1) ?>" class="btn btn-primary">Page Suivante</a>
        <?php endif ?>
    </div>

</body>

</html>