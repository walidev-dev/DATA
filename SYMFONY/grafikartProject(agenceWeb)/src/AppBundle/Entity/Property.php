<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Property
 *
 * @ORM\Table(name="property")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PropertyRepository")
 * @UniqueEntity("title")
 * @Vich\Uploadable
 */
class Property
{
    /**
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="imageName")
     * @var File
     * @Assert\Image(mimeTypes={"image/jpeg","image/jpg","image/png"},mimeTypesMessage="L'image uploadé n'a pas le format requis (jpg / png).")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Option_",inversedBy="properties")
     */
    private $options_;

    const HEAT = [
        0 => 'Electrique',
        1 => 'Gaz'
    ];

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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     * @Assert\Length(min="5",minMessage="vous devez au moins saisir 5 caractéres",max="255",maxMessage="c'est limité à 255 caratéres")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="surface",type="integer",nullable=true)
     * @Assert\Range(min="10",max="400")
     */
    private $surface;

    /**
     * @ORM\Column(name="rooms",type="smallint")
     */
    private $rooms;

    /**
     * @ORM\Column(name="floor",type="smallint")
     */
    private $floor;

    /**
     * @ORM\Column(name="bedrooms",type="smallint")
     */
    private $bedrooms;

    /**
     * @ORM\Column(name="price",type="integer")
     */
    private $price;

    /**
     * @ORM\Column(name="heat",type="integer")
     */
    private $heat;

    /**
     * @ORM\Column(name="city",type="string")
     */
    private $city;

    /**
     * @ORM\Column(name="address",type="string")
     */
    private $address;

    /**
     * @ORM\Column(name="postal_code",type="string")
     * @Assert\Regex(pattern="/^[0-9]{5}$/",htmlPattern="^[0-9]{5}$",message="le code postal ne doit contenir que 5 chiffres.")
     */
    private $postal_code;

    /**
     * @ORM\Column(name="sold",type="boolean",options={"default": false})
     */
    private $sold = false;

    /**
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $created_at;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

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
     * @return Property
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

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getHeatType(): string
    {
        return self::HEAT[$this->heat];
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Property
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set surface
     *
     * @param integer $surface
     *
     * @return Property
     */
    public function setSurface($surface)
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * Get surface
     *
     * @return integer
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     * Set rooms
     *
     * @param integer $rooms
     *
     * @return Property
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get rooms
     *
     * @return integer
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set floor
     *
     * @param integer $floor
     *
     * @return Property
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get floor
     *
     * @return integer
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set bedrooms
     *
     * @param integer $bedrooms
     *
     * @return Property
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    /**
     * Get bedrooms
     *
     * @return integer
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Property
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function getFormattedPrice()
    {
        return number_format($this->price, 0, '', ' ');
    }

    /**
     * Set heat
     *
     * @param integer $heat
     *
     * @return Property
     */
    public function setHeat($heat)
    {
        $this->heat = $heat;

        return $this;
    }

    /**
     * Get heat
     *
     * @return integer
     */
    public function getHeat()
    {
        return $this->heat;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Property
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Property
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Property
     */
    public function setPostalCode($postalCode)
    {
        $this->postal_code = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * Set sold
     *
     * @param boolean $sold
     *
     * @return Property
     */
    public function setSold($sold)
    {
        $this->sold = $sold;

        return $this;
    }

    /**
     * Get sold
     *
     * @return boolean
     */
    public function getSold()
    {
        return $this->sold;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Property
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Add option.
     *
     * @param \AppBundle\Entity\Option_ $option
     *
     * @return Property
     */
    public function addOption(\AppBundle\Entity\Option_ $option)
    {
        $this->options_[] = $option;

        return $this;
    }

    /**
     * Remove option.
     *
     * @param \AppBundle\Entity\Option_ $option
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOption(\AppBundle\Entity\Option_ $option)
    {
        return $this->options_->removeElement($option);
    }

    /**
     * Get options.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptions()
    {
        return $this->options_;
    }

    /**
     * @return File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     * @return Property
     */
    public function setImageFile(File $imageFile): Property
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param mixed $imageName
     * @return Property
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
        return $this;
    }

}
