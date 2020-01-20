<?php

namespace App\Validators;

use Valitron\Validator;

abstract class AbstractValidator
{
    protected $errors = [];

    protected $validator;

    public function __construct(array $data)
    {
        $this->validator = new Validator($data);
    }

    public function validate(): bool
    {
        return (empty($this->errors)) ? true : false;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
