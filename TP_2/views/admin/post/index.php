<?php

use App\Auth;
use App\Table\Exceptions\ForBiddenException;
use App\Session;

try {
    Auth::check();
} catch (ForBiddenException $e) {
    Session::setFlash('danger', $e->getMessage());
    header('Location: ' . $router->url('login'));
    exit;
}


use App\Connection;
use App\Table\PostTable;


$title = 'Administration Des Articles';
$pdo = Connection::getPDO();
list($posts, $paginator) = (new PostTable($pdo))->findPaginated();

?>
<?php if (Session::hasFlash('success')) : ?>
    <div class="alert alert-success">
        <?= Session::getFlash('success'); ?>
    </div>
<?php endif ?>
<a href="<?= $router->url('admin_post_new') ?>" class="btn btn-lg btn-primary">Ajouter un article</a>

<table class="table" style="margin-top:10px">
    <thead>
        <th>ID</th>
        <th>Titre</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach ($posts as $post) : ?>
            <tr>
                <td>#<?= $post->getID() ?></td>
                <td><?= htmlentities($post->getName()) ?></td>
                <td>
                    <a href="<?= $router->url('admin_post_edit', ['id' => $post->getID()]) ?>" class="btn btn-info">
                        Editer
                    </a>
                    <form action="<?= $router->url('admin_post_delete', ['id' => $post->getID()]) ?>" onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display:inline" method="POST">
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