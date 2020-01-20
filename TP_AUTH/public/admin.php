<?php
require_once '../vendor/autoload.php';

use App\App;
use App\Exceptions\ForbiddenException;

session_start();


try {

    App::getAuth()->requireRole('admin');
} catch (ForbiddenException $ex) {
    die($ex->getMessage());
}


?>

Réservé à l'admin