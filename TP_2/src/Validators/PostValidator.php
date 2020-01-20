<?php

namespace App\Validators;

use App\Table\PostTable;

class PostValidator extends AbstractValidator
{


    public function __construct(array $data, PostTable $postTable, int $id = null, array $options)
    {
        parent::__construct($data);

        $this->validator->labels([
            'name' => 'Le titre',
            'content' => 'Le contenu',
            'slug' => 'L\'URL'
        ]);

        $this->validator
            ->rule('required', array_keys($data))
            ->rule('lengthBetween', ['name', 'slug'], 3, 200)
            ->rule('slug', 'slug')
            ->rule('subset', 'categories', array_keys($options))
            ->rule(function ($field, $value) use ($postTable, $id) {
                return !$postTable->exists($field, $value, $id);
            }, ['slug', 'name'], 'est déja utilisé')
            ->rule('lengthBetween', 'content', 3, 2000);

        if ($this->validator->validate() === false) {
            $this->errors = $this->validator->errors();
        }
    }
}
