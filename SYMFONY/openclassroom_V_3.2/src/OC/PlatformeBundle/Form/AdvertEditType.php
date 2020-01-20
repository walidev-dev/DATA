<?php
/**
 * Created by PhpStorm.
 * User: oulah
 * Date: 27/02/18
 * Time: 08:12 ص
 */

namespace OC\PlatformeBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdvertEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->remove('content')
           ->remove('published')
           ->remove('image')
           ->remove('categories');
    }
    public function getParent()
    {
        return AdvertType::class;
    }

}