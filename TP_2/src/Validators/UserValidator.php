<?php

namespace App\Validators;



class UserValidator extends AbstractValidator
{


    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->validator->labels([
            'username' => "Le nom d'utilisateur",
            'password' => 'Le mot de passe'
        ]);

        $this->validator
            ->rule('required', array_keys($data))
            ->rule('lengthBetween', ['username', 'password'], 3, 200);
        if ($this->validator->validate() === false) {
            $this->errors = $this->validator->errors();
        }
    }
}
