<?php

namespace App\Models;

class User
{
    private $firstName;

    private $email;

    public function __construct()
    { }

    public function setFirstName($firstName)
    {
        $this->firstName = trim($firstName);
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getEmailVariables()
    {
        return [
            'firstName' => $this->firstName,
            'email' => $this->email
        ];
    }
}
