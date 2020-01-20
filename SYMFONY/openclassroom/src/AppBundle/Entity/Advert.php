<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Antiflood;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdvertRepository")
 * @UniqueEntity(fields={"title"},message="Ce titre est déja utilisé.")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug",type="string",length=255)
     */
    private $slug;

    /**
     * @ORM\Column(name="nb_applications",type="integer")
     */
    private $nbApplications = 0;

    public function increaseApplication()
    {
        $this->nbApplications++;
    }

    public function decreaseApplication()
    {
        $this->nbApplications--;
    }

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Application",mappedBy="advert",orphanRemoval=true)
     */
    private $applications;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image",cascade={"persist","remove"})
     * @Assert\Valid()
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category")
     */
    private $categories;

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
     * @ORM\Column(name="title", type="string", length=255,unique=true)
     * @Assert\Length(min=10,minMessage="Le Titre doit faire au moins {{ limit }} caractéres.")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     * @Assert\Length(min=2,minMessage="L'autheur doit faire au moins {{ limit }} caractéres.")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message="Le contenu ne peut pas être vide.")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime(message="Merci de renseigner une date valide")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published",type="boolean")
     */
    private $published;

    /**
     * @ORM\Column(name="update_at",type="datetime",nullable=true)
     */
    private $updateAt;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->categories = new ArrayCollection();
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
     * @return Advert
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
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Advert
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param Image $image
     * @return $this
     */
    public function setImage(\AppBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Advert
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add application.
     *
     * @param \AppBundle\Entity\Application $application
     *
     * @return Advert
     */
    public function addApplication(\AppBundle\Entity\Application $application)
    {
        $this->applications[] = $application;
        $application->setAdvert($this);
        return $this;
    }

    /**
     * Remove application.
     *
     * @param \AppBundle\Entity\Application $application
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeApplication(\AppBundle\Entity\Application $application)
    {
        return $this->applications->removeElement($application);
    }

    /**
     * Get applications.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set updateAt.
     *
     * @param \DateTime|null $updateAt
     *
     * @return Advert
     */
    public function setUpdateAt($updateAt = null)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt.
     *
     * @return \DateTime|null
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdateAt(new \DateTime());
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Advert
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set nbApplications.
     *
     * @param int $nbApplications
     *
     * @return Advert
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;

        return $this;
    }

    /**
     * Get nbApplications.
     *
     * @return int
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }

    /**
     * Set user.
     *
     * @param \UserBundle\Entity\User|null $user
     *
     * @return Advert
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }


    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
