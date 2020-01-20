<?php
define('DS',DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR.DS);

require_once ROOT.'vendor/autoload.php';

use App\App;

$app = App::getInstance();


if (isset($_GET['p'])) {
    $p = $_GET['p'];
} else {
    $p = 'home';
}


ob_start();

if ($p === 'home') {
    $app->setTitle("Page d'accueil");
    $postTable = $app->getTable('Post');
    $categoryTable = $app->getTable('Category');
    require ROOT.'/pages/home.php';
} else if ($p === 'post') {
    $app->setTitle("Page d'article");
    $postTable = $app->getTable('Post');
    require ROOT.'/pages/post.php';
} else if ($p === 'category') {
    $app->setTitle("Page de catégorie");
    $postTable = $app->getTable('Post');
    $categoryTable = $app->getTable('Category');
    require ROOT.'/pages/category.php';
} else if ($p === '404') {
    require ROOT.'/pages/404.php';
}

$content = ob_get_clean();

require ROOT.'pages/templates/default.php';
