<?php

namespace OC\PlatformeBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ListAdvertsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Annonces', EntityType::class, array(
                    'class' => 'OCPlatformeBundle:Advert',
                    'choice_label' => 'title',
                    'choice_value' => 'id',
                    'multiple' => false,
                    'placeholder' => "--Séléctionnez une annonce--"
                )
            );
    }


}