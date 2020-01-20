<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\InvitationCode;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadInvitationCodeData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerAwareInterface $container
     */
    private $container;

    public function load(ObjectManager $manager)
    {
        $code = (new InvitationCode())
            ->setCode('54321')
            ->setDescription('Description bidon pour ce code')
            ->setExpireAt(new \DateTime("+1 YEAR"));

        $manager->persist($code);
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}