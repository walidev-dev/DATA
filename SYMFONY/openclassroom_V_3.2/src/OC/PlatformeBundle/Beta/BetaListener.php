<?php

namespace OC\PlatformeBundle\Beta;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
    protected $betaHTML;

    protected $endDate;

    public function __construct(BetaHTMLAdder $betaHTMLAdder,$endDate){
      $this->endDate=new \DateTime();
      $this->betaHTML=$betaHTMLAdder;
    }

    public function processBeta(FilterResponseEvent $event){
        if(!$event->isMasterRequest()){
           return;
        }
        $remainingDays=$this->endDate->diff(new \DateTime())->days;
        if($remainingDays <= 0){
            return;
        }
         $response=$this->betaHTML->addBeta($event->getResponse(),$remainingDays);
         $event->setResponse($response);
    }

}