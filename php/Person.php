<?php
class Person
{

    public $id;

    public $firstname;

    public $lastname;

    public $birth_date;

    public $registration_date;

    public function getBirthDate()
    {
        $date = new DateTime($this->birth_date);
        return $date->format('d/m/Y');
    }
}
