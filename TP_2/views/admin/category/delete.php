<?php

use App\Connection;
use App\Session;
use App\Table\CategoryTable;

$id = (int) $params['id'];
$pdo = Connection::getPDO();
(new CategoryTable($pdo))->delete($id);
Session::setFlash('success', 'L\'enregistrement a bien été supprimé');
header("Location: " . $router->url('admin_categories'));
