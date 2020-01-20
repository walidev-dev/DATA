<?php

namespace AppBundle\Bigbrother;

use Symfony\Component\Security\Core\User\UserInterface;

class MessageNotificator
{

    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notifyByEmail(string $message, UserInterface $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject("Nouveau message d'un utilisateur surveillé")
            ->setFrom('admin@admin.com')
            ->setTo('admin@admin.com')
            ->setBody("L'utilisateur surveillé " . $user->getUsername() . " a posté le message suivant " . $message);

        $this->mailer->send($message);
    }
}