<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Antiflood extends Constraint
{

    public $message = "Vous avez déja posté un message Il y a moins de 15 secondes,Merci de patienter un peu.";

    public function validatedBy()
    {
        return 'app.antiflood_validator';
    }
}