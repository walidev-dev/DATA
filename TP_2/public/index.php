<?php
define('BASE_URI', '/TP_2/public');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__) . DS);
define('VIEW_PATH', ROOT . 'views' . DS);
define('DEBUG_TIME', microtime(true));
setlocale(LC_TIME, array('fr_FR.UTF-8', 'fr_FR@euro', 'fr_FR', 'french'));
require ROOT . 'vendor/autoload.php';
session_start();

use App\Router;
use Valitron\Validator;


Validator::lang('fr');

$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
$whoops->register();

/* REDIRECTION PERMANANTE POUR LA 1ÉRE PAGE (PAGINATION) */

if (isset($_GET['page']) && $_GET['page'] === '1') {
    $url = str_replace('?page=1', '', $_SERVER['REQUEST_URI']);
    http_response_code(301);
    header('Location: ' . $url);
}

(new Router(VIEW_PATH))
    ->get(BASE_URI . '/', 'post/index', 'home')
    ->get(BASE_URI . '/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
    ->get(BASE_URI . '/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->match(BASE_URI . '/login', 'auth/login', 'login')
    ->get(BASE_URI . '/logout', 'auth/logout', 'logout')
    ->get(BASE_URI . '/admin', 'admin/post/index', 'admin_posts')
    ->get(BASE_URI . '/admin/category', 'admin/category/index', 'admin_categories')
    ->match(BASE_URI . '/admin/post/[i:id]', 'admin/post/edit', 'admin_post_edit')
    ->match(BASE_URI . '/admin/category/[i:id]', 'admin/category/edit', 'admin_category_edit')
    ->match(BASE_URI . '/admin/post/new', 'admin/post/new', 'admin_post_new')
    ->match(BASE_URI . '/admin/category/new', 'admin/category/new', 'admin_category_new')
    ->post(BASE_URI . '/admin/post/delete/[i:id]', 'admin/post/delete', 'admin_post_delete')
    ->post(BASE_URI . '/admin/category/delete/[i:id]', 'admin/category/delete', 'admin_category_delete')
    ->run();
