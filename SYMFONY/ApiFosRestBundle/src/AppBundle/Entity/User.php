<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Serializer\Groups({"public"})
     * @ORM\Column(name="username", type="string", length=255,unique=true)
     */
    private $username;

    /**
     * @Serializer\Groups({"public"})
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {

    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getCredentials()
    {

    }

    public function eraseCredentials()
    {

    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
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
}
