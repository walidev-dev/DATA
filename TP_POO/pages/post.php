<?php
$post = $postTable->find($_GET['id']);
if ($post === false) {
    $app->notFound();
}
?>

<h1><?= $post->titre ?></h1>
<p>
    <?= $post->contenu ?>
</p>