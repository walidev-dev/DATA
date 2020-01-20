<div class="row">
    <div class="col-md-8">
        <?php foreach ($postTable->getLast() as $post) : ?>
            <h2><a href="<?= $post->url ?>"><?= $post->titre ?></a></h2>
            <p><em><?= $post->categorie ?></em></p>
            <p>
                <?= $post->excerpt; ?>
            </p>
        <?php endforeach; ?>
    </div>
    <div class="col-md-4">
        <h4> Catégories : </h4>
        <ul style="padding-left:20px">
            <?php foreach ($categoryTable->all() as $category) : ?>
                <li><a href="<?= $category->url ?>"><?= $category->nom ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
</div>