<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SubCategory",inversedBy="posts")
     * @Assert\NotBlank()
     */
    private $sub_category;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subCategory
     *
     * @param \AppBundle\Entity\SubCategory $subCategory
     *
     * @return Post
     */
    public function setSubCategory(\AppBundle\Entity\SubCategory $subCategory = null)
    {
        $this->sub_category = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return \AppBundle\Entity\SubCategory
     */
    public function getSubCategory()
    {
        return $this->sub_category;
    }
}
