<?php

namespace AppBundle\Subscriber;

use AppBundle\Mailer\AppMailer;
use Scitap\BadgeBundle\Event\BadgeUnlockEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class BadgeSubscriber implements EventSubscriberInterface
{

    /**
     * @var AppMailer $appMailer
     */
    private $appMailer;

    /**
     * BadgeSubscriber constructor.
     * @param AppMailer $appMailer
     */
    public function __construct(AppMailer $appMailer)
    {
        $this->appMailer = $appMailer;
    }


    public static function getSubscribedEvents()
    {
        return [
            BadgeUnlockEvent::NAME => 'onBadgeUnlock'
        ];

    }

    public function onBadgeUnlock(BadgeUnlockEvent $event)
    {
        return $this->appMailer->badgeUnlocked($event->getBadge(), $event->getUser());
    }
}