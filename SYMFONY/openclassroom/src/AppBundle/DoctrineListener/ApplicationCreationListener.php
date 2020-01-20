<?php

namespace AppBundle\DoctrineListener;


use AppBundle\Entity\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ApplicationCreationListener
{
    /**
     * @var ApplicationMailer
     */
    private $applicationMailer;

    public function __construct(ApplicationMailer $applicationMailer)
    {
        $this->applicationMailer = $applicationMailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Application) {
            return;
        }

        $this->applicationMailer->sendNewNotification($entity);

    }

}