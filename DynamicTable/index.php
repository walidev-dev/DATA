<?php
require_once 'vendor/autoload.php';

use App\Connexion;
use App\NumberHelper;
use App\QueryBuilder;
use App\Table;

$queryBuilder = new QueryBuilder(Connexion::getPDO());

$query = $queryBuilder->from('products');



/*       RECHERCHE PAR VILLE        */

if (isset($_GET['q']) && strlen(trim($_GET['q'])) > 0) {
    $q = trim($_GET['q']);
    $query
        ->where("city LIKE :city")
        ->setParam('city', '%' . $q . '%');
}


$table = (new Table($query, $_GET))
    ->setColumns([
        'id' => 'ID',
        'name' => 'NOM',
        'city' => 'VILLE',
        'price' => 'PRIX'
    ])->addFormatter('price', function ($value) {
        return NumberHelper::price($value);
    })->sortable('id', 'city');

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
    <div class="container-fluid">
        <h2> Tous les biens </h2>
        <form action="">
            <div class="form-group">
                <input type="text" name="q" placeholder="Rechercher par ville" class="form-control" value="<?= (!empty($_GET['q'])) ? htmlentities($_GET['q']) : null ?>">
            </div>
            <button class="btn btn-primary">Rechercher</button>
        </form>
        <hr>

        <?php $table->render(); ?>

    </div>

</body>

</html>