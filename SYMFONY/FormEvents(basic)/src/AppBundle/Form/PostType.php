<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Title of post'
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => false,
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a category',
                'mapped' => false
            ]);

        $builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                /** @var Category $category */
                $category = $form->getData();
                $this->addSubCategoryField($form->getParent(), $category);
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                /** @var Post $post */
                $post = $event->getData();
                /** @var SubCategory $subCategory */
                $subCategory = $post->getSubCategory();
                if ($subCategory) {
                    $category = $subCategory->getCategory();
                    $form->get('category')->setData($category);
                    $this->addSubCategoryField($form, $category);
                } else {
                    $this->addSubCategoryField($form, null);
                }
            }
        );

    }

    public function addSubCategoryField(FormInterface $form, ?Category $category)
    {
        $form->add('sub_category', EntityType::class, [
            'class' => SubCategory::class,
            'choices' => $category ? $category->getSubCategories() : [],
            'choice_label' => 'name',
            'label' => false,
            'placeholder' => 'Select a sub category'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
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
