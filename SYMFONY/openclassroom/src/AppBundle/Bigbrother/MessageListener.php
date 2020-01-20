<?php

namespace AppBundle\Bigbrother;

use AppBundle\Events\MessagePostEvent;

class MessageListener
{
    protected $messageNotificator;
    protected $users = [];

    public function __construct(MessageNotificator $messageNotificator, array $users)
    {
        $this->messageNotificator = $messageNotificator;
        $this->users = $users;
    }

    public function processMessage(MessagePostEvent $event)
    {
        if (in_array($event->getUser(), $this->users)) {
            $this->messageNotificator->notifyByEmail($event->getMessage(), $event->getUser());
        }
    }
}