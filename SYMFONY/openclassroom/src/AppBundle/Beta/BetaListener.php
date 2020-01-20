<?php

namespace AppBundle\Beta;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
    protected $betaHTML;
    protected $endDate;

    public function __construct(BetaHTMLAdder $betaHTMLAdder, $endDate)
    {
        $this->betaHTML = $betaHTMLAdder;
        $this->endDate = new \DateTime($endDate);
    }

    public function processBeta(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $dateInterval = $this->endDate->diff(new \DateTime('now'));

        if ($dateInterval->invert === 0) {
            return;
        }

        $response = $this->betaHTML->addBeta($event->getResponse(), $dateInterval->format('%a'));
        $event->setResponse($response);
    }


}