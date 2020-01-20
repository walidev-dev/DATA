<?php

namespace Grafikart\TagBundle\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Grafikart\TagBundle\Form\DataTransformer\TagTransformer;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('required', false)
            ->setDefault('attr', ['class' => 'tag-input']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new TagTransformer($this->em), true);
    }

    public function getParent()
    {
        return TextType::class;
    }
}