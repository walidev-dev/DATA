<?php

use App\Connection;
use App\Session;
use App\Table\PostTable;

$id = (int) $params['id'];
$pdo = Connection::getPDO();
(new PostTable($pdo))->delete($id);
Session::setFlash('success', 'L\'enregistrement a bien été supprimé');
header("Location: " . $router->url('admin_posts'));
