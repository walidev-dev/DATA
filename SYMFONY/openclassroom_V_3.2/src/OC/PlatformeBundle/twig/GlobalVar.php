<?php

namespace OC\PlatformeBundle\twig;

use Doctrine\ORM\EntityManager;


class GlobalVar
{
    private $twig;
    private $em;

    public function __construct(\Twig_Environment $twig, EntityManager $em)
    {
        $this->twig = $twig;
        $this->em = $em;
    }

    public function onKernelRequest()
    {
        $repository = $this->em->getRepository('OCPlatformeBundle:Advert');
        $adverts = $repository->findBy(
            [],
            ['date' => 'DESC'],
            3,
            0
        );
        $this->twig->addGlobal('adverts', $adverts);

    }

}