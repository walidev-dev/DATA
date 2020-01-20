<?php
namespace OC\PlatformeBundle\Event;


use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class MessagePostEvent extends Event
{
    protected $message;
    protected $user;
    public function __construct($message,UserInterface $user){
        $this->message=$message;
        $this->user=$user;
    }
    public function getMessage(){
        return $this->message;
    }
    public function setMessage($message){
        $this->message=$message;
    }
    public function getUser(){
        return $this->user;
    }
}