<?php

use App\Connection;
use App\Models\Category;
use App\Table\CategoryTable;
use App\Table\PostTable;

/* RÉCUPERER LES PARAMAETRES DE L'URL */

$id = (int) $params['id'];
$slug = $params['slug'];

/* RÉCUPERER L'ARTICLE  */

$pdo = Connection::getPDO();
$post = (new PostTable($pdo))->find($id);

/* REDIRECTION PERMANANTE SI LE SLUG EST MODIFIÉ */

if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['id' => $id, 'slug' => $post->getSlug()]);
    http_response_code(301);
    header('Location: ' . $url);
}

/* RÉCUPERER LES CATEGORIES LIÉES À CET ARTICLE ET LES AFFECTER À L'ATTRIBUT CATEGORIES DU POST */

(new CategoryTable($pdo))->hydratePosts([$post]);

$categories_html = Category::arrayToHTML($post, $router);


?>

<!-- L'AFFICHAGE DE L'ARTICLE + CES CATÉGORIES LIÉES-->

<h1><?= htmlentities($post->getName()) ?></h1>

<p class="text-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?></p>

<?= implode(',', $categories_html) ?>

<p><?= $post->getFormattedContent() ?></p>