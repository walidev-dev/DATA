<?php

use App\Connection;
use App\HTML\Form;
use App\Object_;
use App\Session;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

$id = (int) $params['id'];
$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($id);
$errors = [];

if (!empty($_POST)) {
    $v = new CategoryValidator($_POST, $categoryTable, $category->getID());

    if ($v->validate()) {
        Object_::hydrate($category, $_POST, ['name', 'slug']);
        $categoryTable->update($category);
        Session::setFlash('success', 'La catégorie a bien été modifiée');
        header("Location: " . $router->url('admin_categories'));
    } else {
        $errors = $v->errors();
        Session::setFlash('danger', 'La catégorie n\'a pas pû être modifiée , Merci de corriger vos erreurs');
    }
}

$form = new Form($category->toArray(), $errors);

?>
<h3>Formulaire d'edition de la categorie d'ID : <?= $category->getID(); ?> </h3>

<?php require 'FormTemplate.php' ?>