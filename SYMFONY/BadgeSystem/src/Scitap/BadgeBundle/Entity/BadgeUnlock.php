<?php

namespace Scitap\BadgeBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * BadgeUnlock
 *
 * @ORM\Table(name="badge_unlock")
 * @ORM\Entity(repositoryClass="Scitap\BadgeBundle\Repository\BadgeUnlockRepository")
 */
class BadgeUnlock
{
    /**
     * @var Badge
     *
     * @ORM\ManyToOne(targetEntity="Scitap\BadgeBundle\Entity\Badge",inversedBy="badgeUnlocks")
     */
    private $badge;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="badgeUnlocks")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * Set badge.
     *
     * @param \Scitap\BadgeBundle\Entity\Badge|null $badge
     *
     * @return BadgeUnlock
     */
    public function setBadge(\Scitap\BadgeBundle\Entity\Badge $badge = null)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * Get badge.
     *
     * @return \Scitap\BadgeBundle\Entity\Badge|null
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return BadgeUnlock
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
