<?= $renderer->render('header', ['title' => 'Mon Blog']); ?>
<h1>Bienvenu sur le blog</h1>

<ul>
    <li><a href="<?php echo $router->generateUri('blog.show', ['slug' => 'mon-slug','id' => 15]) ?>">Mon Article</a></li>
    <li><a href="#">Article 2</a></li>
    <li><a href="#">Article 3</a></li>
    <li><a href="#">Article 4</a></li>
</ul>
<?= $renderer->render('footer'); ?>
