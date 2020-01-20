<?php

namespace AppBundle\Events;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class MessagePostEvent extends Event
{

    protected $message;
    protected $user;

    public function __construct(string $message, UserInterface $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

}