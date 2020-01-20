<?php
require_once '../vendor/autoload.php';
session_start();

use App\App;

App::getAuth()->requireRole('user', 'admin');

?>
Réservé à l'utilisateur