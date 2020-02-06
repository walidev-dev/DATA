<?php

namespace AppBundle\FormHelper;

use Symfony\Component\Form\FormInterface;

class FormError
{

    /**
     * @param FormInterface $form
     * @return array
     */
    public function getErrors(FormInterface $form): array
    {
        $errors = [];

        if (!$form->isValid()) {
            foreach ($form->getErrors(true, false) as $error) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }
        }

        return $errors;
    }
}