<?php
/* $categories_html = [];
foreach ($post->getCategories() as $category) {
    $url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
    $categoryName = htmlentities($category->getName());
    $categories_html[] = <<<HTML
    <a href="{$url}">{$categoryName}</a>
HTML;
} */

use App\Models\Category;

$categories_html = Category::arrayToHTML($post, $router);

?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
        <p class="text-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?>::
            <?php if (!empty($post->getCategories())) : ?>
                <?= implode(',', $categories_html) ?>
            <?php endif ?>
        </p>

        <p class="card-text"><?= $post->getExcerpt() ?></p>
        <p>
            <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary">Voir plus</a>
        </p>
    </div>
</div>