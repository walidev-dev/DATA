<?php

namespace App\Exceptions;

class ForbiddenException extends \Exception
{

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
}
