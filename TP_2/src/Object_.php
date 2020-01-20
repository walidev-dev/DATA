<?php

namespace App;

class Object_
{

    public static function hydrate($entity, array $data, array $fields): void
    {

        foreach ($fields as $field) {
            $method = 'set' . ucfirst($field);
            $entity->$method($data[$field]);
        }
    }
}
