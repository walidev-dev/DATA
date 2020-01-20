<?php

namespace OC\PlatformeBundle\Bigbrother;


use OC\PlatformeBundle\Event\MessagePostEvent;

class MessageListener
{
    private $notificator;

    private $listUsers=[];

    public function __construct(MessageNotificator $notificator,$listUsers){
        $this->notificator=$notificator;
        $this->listUsers=$listUsers;
    }

    public function processMessage(MessagePostEvent $event){
        if(in_array($event->getUser()->getUsername(),$this->listUsers)){
            $this->notificator->notifyByEmail($event->getMessage(),$event->getUser());
        }
    }

}