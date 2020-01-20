<?php

namespace AppBundle\Form;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Region;
use AppBundle\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinType extends AbstractType
{
    private function addDepartementField(FormInterface $form, ?Region $region)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'departement',
            EntityType::class,
            null,
            [
                'class' => Departement::class,
                'choice_label' => 'name',
                'choices' => $region ? $region->getDepartements() : [],
                'placeholder' => 'Sélectionnez votre département',
                'auto_initialize' => false,
                'required' => false,
                'mapped' => false
            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                if (!is_null($form->getData())) {
                    $this->addVilleField($form->getParent(), $form->getData());
                }

            }
        );
        $form->add($builder->getForm());
    }

    private function addVilleField(FormInterface $form, ?Departement $departement)
    {
        $form->add('ville',
            EntityType::class,
            [
                'class' => Ville::class,
                'choice_label' => 'name',
                'choices' => $departement ? $departement->getVilles() : [],
                'placeholder' => 'Sélectionnez votre ville'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['label' => 'Nom'])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez votre région',
                'mapped' => false,
                'required' => false
            ]);
        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                if (!is_null($form->getData())) {
                    $this->addDepartementField($form->getParent(), $form->getData());
                }
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $medecin = $event->getData();
                /** @var Ville $ville */
                $ville = $medecin->getVille();
                if ($ville) {
                    $departement = $ville->getDepartement();
                    $region = $departement->getRegion();
                    $this->addDepartementField($form, $region);
                    $this->addVilleField($form, $departement);
                    $form->get('region')->setData($region);
                    $form->get('departement')->setData($departement);
                } else {
                    $this->addDepartementField($form, null);
                    $this->addVilleField($form, null);
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Medecin'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }


}
