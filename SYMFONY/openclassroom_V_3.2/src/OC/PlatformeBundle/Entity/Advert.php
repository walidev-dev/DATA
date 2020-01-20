<?php

namespace OC\PlatformeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use OC\PlatformeBundle\Validator\Antiflood;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="OC\PlatformeBundle\Repository\AdvertRepository")
 * @UniqueEntity(fields="title",message="Une annonce existe déja avec ce titre. ")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{

    /**
     * @ORM\Column(name="nb_applications",type="integer")
     */
     private  $nbApplications=0;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug",type="string",length=255,nullable=true)
     */
    private $slug;

    public function increaseApplication(){
        $this->nbApplications++;
    }

    public function decreaseApplication(){
        $this->nbApplications--;
    }

    /**
     * @ORM\OneToMany(targetEntity="OC\PlatformeBundle\Entity\Application",mappedBy="advert",cascade={"remove"})
     */
    private $applications;

    /**
     * @ORM\ManyToMany(targetEntity="OC\PlatformeBundle\Entity\Category",inversedBy="adverts")
     * @ORM\JoinTable(name="advert_category")
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255,unique=true)
     * @Assert\Length(min =10,minMessage = "Le titre doit faire au moins {{ limit }} caractéres. ")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255,nullable=true)
     * @Assert\Length(min=2,minMessage = "L'author doit faire au moins {{ limit }} caractéres.")
     */
    private $author;
    
    /**
     * @ORM\ManyToOne(targetEntity="OC\UserBundle\Entity\User",inversedBy="adverts")
     */
    private $user;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text",nullable=true)
     * @Assert\NotBlank(message = "Le contenu ne peut pas être vide")
     */
    private $content;
    /**
     * @var bool
     *
     * @ORM\Column(name="published",type="boolean",nullable=true)
     */
    private $published=true;


    /**
     * @ORM\OneToOne(targetEntity="OC\PlatformeBundle\Entity\Image",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     */

    private $image;

    /**
     * @ORM\Column(name="update_at",type="datetime",nullable=true)
     */
    private $updateAt;
    public function __construct(){
        $this->date=new \DateTime();
        $this->categories=new ArrayCollection();
        $this->applications=new ArrayCollection();
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
     * Set image
     *
     * @param \OC\PlatformeBundle\Entity\Image $image
     *
     * @return Advert
     */
    public function setImage(Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \OC\PlatformeBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add application
     *
     * @param \OC\PlatformeBundle\Entity\Application $application
     *
     * @return Advert
     */
    public function addApplication(\OC\PlatformeBundle\Entity\Application $application)
    {
        $this->applications[] = $application;

        return $this;
    }

    /**
     * Remove application
     *
     * @param \OC\PlatformeBundle\Entity\Application $application
     */
    public function removeApplication(\OC\PlatformeBundle\Entity\Application $application)
    {
        $this->applications->removeElement($application);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Add category
     *
     * @param \OC\PlatformeBundle\Entity\Category $category
     *
     * @return Advert
     */
    public function addCategory(\OC\PlatformeBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \OC\PlatformeBundle\Entity\Category $category
     */
    public function removeCategory(\OC\PlatformeBundle\Entity\Category $category)
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Advert
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate(){
        $this->setUpdateAt(new \DateTime());
    }


//    /**
//     * @ORM\PrePersist
//     */
//    public function modifyUser(){
//        $token=$this->container->get('security.token_storage')->getToken();
//        //$token=$this->get('security.token_storage')->getToken();
//        $user=$token->getUser();
//        $this->setUser($user);
//    }


    /**
     * Set nbApplications
     *
     * @param integer $nbApplications
     *
     * @return Advert
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;

        return $this;
    }

    /**
     * Get nbApplications
     *
     * @return integer
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }

    /**
     * Set slug
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
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set user
     *
     * @param \OC\UserBundle\Entity\User $user
     *
     * @return Advert
     */
    public function setUser(\OC\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \OC\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
