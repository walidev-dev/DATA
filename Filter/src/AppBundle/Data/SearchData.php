<?php
namespace AppBundle\Data;

use AppBundle\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

class SearchData{

    /**
     * @var string
     * @Assert\Regex(pattern="/^[a-zA-Z]*$/",htmlPattern="^[a-zA-Z]*$",message="Le mot clé recherché est invalide")
     */
    public $q = '';

    /**
     * @var Category[]
     */
    public $categories = [];


    /**
     * @var null|integer
     *
     * @Assert\Regex(pattern="/^[0-9]*$/",message="Le prix maximum ne peut accépter que des chiffres")
     */
    public $max;

    /**
     * @var null|integer
     *
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Le prix minimum ne peut accépter que des chiffres")
     */
    public $min;

    /**
     * @var boolean
     */
    public $promo = false;
}