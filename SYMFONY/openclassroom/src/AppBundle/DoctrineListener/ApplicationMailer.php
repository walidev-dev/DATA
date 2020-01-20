<?php

namespace AppBundle\DoctrineListener;

use AppBundle\Entity\Application;

class ApplicationMailer
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNewNotification(Application $application)
    {
        $message = new \Swift_Message(
            'Nouvelle Candidature',
            'Vous avez reçu une nouvelle candidature'
        );
        $message
            ->addTo($application->getAdvert()->getAuthor())
            ->addFrom('admin@votresite.com');

        $this->mailer->send($message);
    }
}