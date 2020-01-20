<?php

use App\Connection;
use App\HTML\Form;
use App\Object_;
use App\Session;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\Validators\PostValidator;

$id = (int) $params['id'];
$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($id);
$options = (new CategoryTable($pdo))->list();
$errors = [];

if (!empty($_POST)) {
    $v = new PostValidator($_POST, $postTable, $post->getID(), $options);

    if ($v->validate()) {
        Object_::hydrate($post, $_POST, ['name', 'content', 'slug']);
        $postTable->update($post, $_POST['categories']);
        Session::setFlash('success', 'L\'article a bien été modifié');
        header("Location: " . $router->url('admin_posts'));
        exit;
    } else {
        $errors = $v->errors();
        Session::setFlash('danger', 'L\'article n\'a pas pû être ajouté , Merci de corriger vos erreurs');
    }
}

$form = new Form($post->toArray(), $errors);
(new CategoryTable($pdo))->hydratePosts([$post]);
$categoriesID_post = $post->getCategoriesID();


?>
<h3>Formulaire d'edition de l'article d'ID : <?= $post->getID(); ?> </h3>

<?php require 'FormTemplate.php' ?>