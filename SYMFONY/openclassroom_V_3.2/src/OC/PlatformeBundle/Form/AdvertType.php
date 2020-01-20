<?php

namespace OC\PlatformeBundle\Form;

use OC\PlatformeBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $pattern="%";
        $builder
            ->add('date',DateTimeType::class)
            ->add('title',TextType::class)
            ->add('content',TextareaType::class)
            ->add('published',CheckboxType::class,['required'=>false])

            // FORMULAIRE DE L'IMAGE
            ->add('image',ImageType::class)

            //FORMULAIRE DES CATEGORIES
            ->add('categories',EntityType::class,array(
                'class'=>'OCPlatformeBundle:Category',
                'choice_label'=>'name',
                'multiple'=>true,
                'query_builder'=>function(CategoryRepository $repository) use($pattern) {
                       return $repository->getLikeQueryBuilder($pattern);
               }
            ))
            //BOUTTON SUBMIT
            ->add('save',SubmitType::class,array(
                    'attr'=>array(
                        'class'=>'btn btn-block btn-primary'
                    )
                )
            );

           $builder->addEventListener(FormEvents::PRE_SET_DATA,function (FormEvent $event){
              $advert=$event->getData();
              if(null === $advert){
                return;
              }
              if(!$advert->getPublished() || null === $advert->getId()){
                  $event->getForm()->add('published',CheckboxType::class,['required'=>false]);
              }else{
                  $event->getForm()->remove('published');
              }
           });
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformeBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_platformebundle_advert';
    }


}
