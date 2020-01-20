<?php

use App\Connection;
use App\HTML\Form;
use App\Models\User;
use App\Validators\UserValidator;
use App\Session;
use App\Object_;
use App\Table\Exceptions\NotFoundException;
use App\Table\UserTable;

$user = new User();
$errors = [];
if (!empty($_POST)) {
    $v = new UserValidator($_POST);

    if ($v->validate()) {
        Object_::hydrate($user, $_POST, ['username', 'password']);
        $userTable = (new UserTable(Connection::getPDO()));
        try {
            $userMatched = $userTable->findByUsername($user->getUsername());
            if (password_verify($_POST['password'], $userMatched->getPassword())) {
                $_SESSION['auth'] = $userMatched->getId();
                Session::setFlash('success', 'Vous vous êtes connecté avec succés');
                header("Location: " . $router->url('admin_posts'));
                exit;
            } else {
                Session::setFlash('danger', 'Erreur de connexion , Merci de verifier vos identifiants');
            }
        } catch (NotFoundException $e) {
            Session::setFlash('danger', 'Erreur de connexion , Merci de verifier vos identifiants');
        }
    } else {
        $errors = $v->errors();
        Session::setFlash('danger', 'Erreur de connexion , Merci de corriger vos erreurs');
    }
}
$form = new Form($user->toArray(), $errors);
?>
<h1>Se connecter</h1>
<form action="" method="POST">
    <?= $form->input("Le nom d'utlisateur", "username") ?>
    <?= $form->input("Le mot de passe", "password") ?>
    <?= $form->submit("Se Connecter") ?>

</form>