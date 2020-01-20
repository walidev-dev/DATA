<?php

namespace App\Validators;

use App\Table\CategoryTable;

class CategoryValidator extends AbstractValidator
{


    public function __construct(array $data, CategoryTable $categoryTable, int $id = null)
    {
        parent::__construct($data);

        $this->validator->labels([
            'name' => 'Le titre',
            'slug' => 'L\'URL'
        ]);

        $this->validator
            ->rule('required', array_keys($data))
            ->rule('lengthBetween', ['name', 'slug'], 3, 200)
            ->rule('slug', 'slug')
            ->rule(function ($field, $value) use ($categoryTable, $id) {
                return !$categoryTable->exists($field, $value, $id);
            }, ['slug', 'name'], 'est déja utilisé')
            ->rule('lengthBetween', 'content', 3, 2000);

        if ($this->validator->validate() === false) {
            $this->errors = $this->validator->errors();
        }
    }
}
