<?php

use App\Connection;
use App\Table\CategoryTable;

$title = 'Administration Des Categories';
$pdo = Connection::getPDO();
list($categories, $paginator) = (new CategoryTable($pdo))->findPaginated();

?>



<a href="<?= $router->url('admin_category_new') ?>" class="btn btn-lg btn-primary">Ajouter une categorie</a>

<table class="table" style="margin-top:10px">
    <thead>
        <th>ID</th>
        <th>Titre</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <td>#<?= $category->getID() ?></td>
                <td><?= htmlentities($category->getName()) ?></td>
                <td>
                    <a href="<?= $router->url('admin_category_edit', ['id' => $category->getID()]) ?>" class="btn btn-info">
                        Editer
                    </a>
                    <form action="<?= $router->url('admin_category_delete', ['id' => $category->getID()]) ?>" onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display:inline" method="POST">
                        <button class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<!-- PAGINATION -->
<div class="d-flex justify-content-between my-4">
    <?= $paginator->previousLink() ?>
    <?= $paginator->nextLink() ?>
</div>