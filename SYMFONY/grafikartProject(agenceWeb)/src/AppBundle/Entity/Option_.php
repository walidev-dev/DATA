<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Option_
 *
 * @ORM\Table(name="option_")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Option_Repository")
 */
class Option_
{

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Property",mappedBy="options_")
     */
    private $properties;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Option_
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->properties = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add property.
     *
     * @param \AppBundle\Entity\Property $property
     *
     * @return Option_
     */
    public function addProperty(\AppBundle\Entity\Property $property)
    {
        $this->properties[] = $property;

        return $this;
    }

    /**
     * Remove property.
     *
     * @param \AppBundle\Entity\Property $property
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProperty(\AppBundle\Entity\Property $property)
    {
        return $this->properties->removeElement($property);
    }

    /**
     * Get properties.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
