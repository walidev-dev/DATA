<?php

namespace OC\PlatformeBundle\Email;
use OC\PlatformeBundle\Entity\Application;

class ApplicationMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer){
        $this->mailer=$mailer;
    }

    public function sendNewNotification(Application $application){
        $message=new \Swift_Message(
            'Nouvelle candidature',
            'Vous avez reçu une nouvelle candidature'
        );
        $message->addTo($application->getAdvert()->getAuthor());
        $message->addFrom('admin@site.com');
        $this->mailer->send($message);
    }
}