<?php

namespace AppBundle\Notification;

use AppBundle\Entity\Contact;
use Twig\Environment;

class ContactNotification
{

    private $mailer;
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->renderer = $renderer;
        $this->mailer = $mailer;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Agence : ' . $contact->getProperty()->getTitle()))
            ->setFrom('noreply@agence.fr')
            ->setTo('contact@agence.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');

        $this->mailer->send($message);

    }
}