<?php

namespace Scitap\BadgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Badge
 *
 * @ORM\Table(name="badge")
 * @ORM\Entity(repositoryClass="Scitap\BadgeBundle\Repository\BadgeRepository")
 */
class Badge
{
    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Scitap\BadgeBundle\Entity\BadgeUnlock",mappedBy="badge")
     */
    private $badgeUnlocks;

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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="action_name", type="string", length=255)
     */
    private $actionName;

    /**
     * @var int
     *
     * @ORM\Column(name="action_count", type="integer")
     */
    private $actionCount;


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
     * @return Badge
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
     * Set actionName.
     *
     * @param string $actionName
     *
     * @return Badge
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;

        return $this;
    }

    /**
     * Get actionName.
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * Set actionCount.
     *
     * @param int $actionCount
     *
     * @return Badge
     */
    public function setActionCount($actionCount)
    {
        $this->actionCount = $actionCount;

        return $this;
    }

    /**
     * Get actionCount.
     *
     * @return int
     */
    public function getActionCount()
    {
        return $this->actionCount;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->badgeUnlocks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add badgeUnlock.
     *
     * @param \Scitap\BadgeBundle\Entity\BadgeUnlock $badgeUnlock
     *
     * @return Badge
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
