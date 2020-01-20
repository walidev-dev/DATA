<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ContainerAwareInterface $container
     */
    protected $container;

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get("security.password_encoder");
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername("user$i@domain.fr");
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($encoder->encodePassword($user, "0000"));
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}