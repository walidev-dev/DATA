<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * InvitationCode
 *
 * @ORM\Table(name="invitation_code")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvitationCodeRepository")
 * @UniqueEntity("code")
 */
class InvitationCode
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=5, unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[0-9]{5}$/")
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expire_at", type="datetime")
     */
    private $expireAt;


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
     * Set description.
     *
     * @param string|null $description
     *
     * @return InvitationCode
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return InvitationCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set expireAt.
     *
     * @param \DateTime $expireAt
     *
     * @return InvitationCode
     */
    public function setExpireAt($expireAt)
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    /**
     * Get expireAt.
     *
     * @return \DateTime
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }
}
