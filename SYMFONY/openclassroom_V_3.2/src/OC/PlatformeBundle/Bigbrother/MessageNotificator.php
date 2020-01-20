<?php
namespace OC\PlatformeBundle\Bigbrother;
use Symfony\Component\Security\Core\User\UserInterface;

class MessageNotificator{

    protected  $mailer;

    public function __construct(\Swift_Mailer $mailer){
        $this->mailer=$mailer;
    }

    public function notifyByEmail($message_,UserInterface $user){
        $message=new \Swift_Message(
            "Nouveau message d'un utilisateur surveillé",
            "L'utilisateur surveillé".$user->getUsername()." a posté le message suivant".$message_
        );
        $message->addTo('admin@site.com');
        $message->addFrom('admin@site.com');
        $this->mailer->send($message);
    }
}