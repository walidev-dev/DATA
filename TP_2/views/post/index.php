<?php

use App\Connection;
use App\Table\PostTable;

echo "<h6 class='text-muted'>Aujourd'hui nous sommes le " . strftime("%d %B %Y %H:%M") . "</h6>";

$title = "Le Blog";

$pdo = Connection::getPDO();

$postTable = new PostTable($pdo);
list($posts, $paginatedQuery) = $postTable->findPaginated();


?>

<h1>Mon Blog</h1>

<!-- AFFICHAGE DE LA PAGE ARTICLE -->

<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-md-3">
            <?php require ROOT . 'views/post/card.php' ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- AFFICHAGE DE LA PAGINATION -->

<?php require ROOT . 'views/post/pagination.php' ?>