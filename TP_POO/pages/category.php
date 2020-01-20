<?php
$id = $_GET['id'];
$category = $categoryTable->find($id);
if ($category === false) {
    $app->notFound();
}
?>
<h2><?= $category->nom ?> : </h2>
<p>
    <?= $category->description ?>
</p>
<h4>Voici les articles liés à cette categorie : </h4>
<?php foreach ($postTable->lastByCategory($id) as $post) : ?>
    <h1><?= $post->titre ?></h1>
    <p>
        <?= $post->contenu ?>
    </p>
<?php endforeach ?>