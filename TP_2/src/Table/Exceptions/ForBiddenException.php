<?php

namespace App\Table\Exceptions;

use Exception;

class ForBiddenException extends Exception
{
    public function __construct()
    {
        $this->message = "Merci de vous connecter pour pouvoir accéder à la page d'administration";
    }
}
