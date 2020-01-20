<?php

namespace App;

use App\Table\Exceptions\ForBiddenException;

class Auth
{
    public static function check()
    {
        if (!isset($_SESSION['auth'])) {
            throw new ForBiddenException();
        }
    }
}
