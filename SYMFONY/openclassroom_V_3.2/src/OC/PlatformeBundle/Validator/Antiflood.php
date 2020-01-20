<?php
namespace OC\PlatformeBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 *  @Annotation
 */
class Antiflood extends Constraint
{
    public $message="Vous avez déja posté un message il y a moins de 15 secondes,merci d'attendre un peu.";
    public function validatedBy()
    {
        return 'oc_platform_antiflood';
    }

}