<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;

/* RÉCUPERER LES PARAMAETRES DEPUIS L'URL */

$id = (int) $params['id'];
$slug = $params['slug'];

$currentPage = (int) ($_GET['page'] ?? 1);

/* RÉCUPERER LES INFOS SUR LA CATÉGORIE */

$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($id);


$title = $category->getName();

/* REDIRECTION PERMANANTE SI LE SLUG EST MODIFIÉ */

if ($category->getSlug() !== $slug) {
    $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    http_response_code(301);
    header('Location: ' . $url);
}

$postTable = new PostTable($pdo);
list($posts, $paginatedQuery) = $postTable->findPaginatedByCategory($category->getID());

?>


<h1>Catégorie : <?= htmlentities($category->getName()) ?></h1>


<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-md-3">
            <?php require ROOT . 'views/post/card.php' ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- AFFICHAGE DE LA PAGINATION -->

<?php require ROOT . 'views/post/pagination.php' ?>