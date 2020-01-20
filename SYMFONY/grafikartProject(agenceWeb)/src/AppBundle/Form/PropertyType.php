<?php

namespace AppBundle\Form;

use AppBundle\Entity\Option_;
use AppBundle\Entity\Property;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('floor')
            ->add('bedrooms')
            ->add('price', TextType::class)
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('options', EntityType::class, [
                'class' => Option_::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Les Options',
                'required' => false
            ])
            ->add('sold')
            ->add('imageFile',FileType::class,[
                'required' => false
            ])
            ->add('save', SubmitType::class,
                ['label' => 'Enregistrer', 'attr' =>
                    [
                        'class' => 'btn btn-block btn-primary',
                    ]
                ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Property',
            'translation_domain' => 'forms'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }

    public function getChoices()
    {
        $choices = [];
        foreach (Property::HEAT as $k => $v) {
            $choices[$v] = $k;
        }
        return $choices;
    }
}
