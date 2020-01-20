<?php
namespace OC\PlatformeBundle\DoctrineListener;

use OC\PlatformeBundle\Email\ApplicationMailer;
use OC\PlatformeBundle\Entity\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
class ApplicationCreationListener{

    private $applicationMailer;

    public function __construct(ApplicationMailer $applicationMailer){
        $this->applicationMailer=$applicationMailer;
    }

    public function postPersist(LifecycleEventArgs $args){
        $entity=$args->getObject();
        if(!$entity instanceof Application){
            return;
        }
        $this->applicationMailer->sendNewNotification($entity);
    }
}