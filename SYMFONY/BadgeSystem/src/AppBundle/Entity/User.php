<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Scitap\BadgeBundle\Entity\BadgeUnlock",mappedBy="user",orphanRemoval=true)
     */
    private $badgeUnlocks;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment",mappedBy="user",orphanRemoval=true)
     */
    private $comments;

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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;


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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    public function getRoles()
    {
        return ['ROLE_USER'];
    }


    public function getSalt()
    {
        return null;
    }


    public function getUsername()
    {
        return $this->email;
    }


    public function eraseCredentials()
    {

    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comment.
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment.
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        return $this->comments->removeElement($comment);
    }

    /**
     * Get comments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add badgeUnlock.
     *
     * @param \Scitap\BadgeBundle\Entity\BadgeUnlock $badgeUnlock
     *
     * @return User
     */
    public function addBadgeUnlock(\Scitap\BadgeBundle\Entity\BadgeUnlock $badgeUnlock)
    {
        $this->badgeUnlocks[] = $badgeUnlock;

        return $this;
    }

    /**
     * Remove badgeUnlock.
     *
     * @param \Scitap\BadgeBundle\Entity\BadgeUnlock $badgeUnlock
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeBadgeUnlock(\Scitap\BadgeBundle\Entity\BadgeUnlock $badgeUnlock)
    {
        return $this->badgeUnlocks->removeElement($badgeUnlock);
    }

    /**
     * Get badgeUnlocks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBadgeUnlocks()
    {
        return $this->badgeUnlocks;
    }
}
