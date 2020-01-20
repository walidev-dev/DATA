<?php

namespace Scitap\BadgeBundle\Event;

use AppBundle\Entity\User;
use Scitap\BadgeBundle\Entity\Badge;
use Scitap\BadgeBundle\Entity\BadgeUnlock;
use Symfony\Component\EventDispatcher\Event;

class BadgeUnlockEvent extends Event
{

    const NAME = 'badge.unlock';

    /**
     * @var BadgeUnlock $badgeUnlock
     */
    private $badgeUnlock;

    /**
     * BadgeUnlockEvent constructor.
     * @param BadgeUnlock $badgeUnlock
     */
    public function __construct(BadgeUnlock $badgeUnlock)
    {
        $this->badgeUnlock = $badgeUnlock;
    }

    /**
     * @return BadgeUnlock
     */
    public function getBadgeUnlock(): BadgeUnlock
    {
        return $this->badgeUnlock;
    }

    public function getBadge(): Badge
    {
        return $this->badgeUnlock->getBadge();
    }

    public function getUser(): User
    {
        return $this->badgeUnlock->getUser();
    }

}