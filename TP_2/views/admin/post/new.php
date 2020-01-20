<?php

use App\Connection;
use App\HTML\Form;
use App\Models\Post;
use App\Object_;
use App\Session;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Validators\PostValidator;

$post = new Post();
$errors = [];
$pdo = Connection::getPDO();
$options = (new CategoryTable($pdo))->list();
if (!empty($_POST)) {


    $postTable = new PostTable($pdo);
    $v = new PostValidator($_POST, $postTable, null, $options);

    if ($v->validate()) {
        Object_::hydrate($post, $_POST, ['name', 'content', 'slug']);
        $postTable->create($post, $_POST['categories']);
        Session::setFlash('success', 'L\'article a bien été ajouté');
        header("Location: " . $router->url('admin_posts'));
        exit;
    } else {
        $errors = $v->errors();
        Session::setFlash('danger', 'L\'article n\'a pas pû être ajouté , Merci de corriger vos erreurs');
    }
}

$form = new Form($post->toArray(), $errors);

$categoriesID_post = [];
?>
<h3>Formulaire d'ajout d'un article</h3>

<?php require 'FormTemplate.php' ?>