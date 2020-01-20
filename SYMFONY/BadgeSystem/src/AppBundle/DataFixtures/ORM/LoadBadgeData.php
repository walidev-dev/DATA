<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Scitap\BadgeBundle\Entity\Badge;

class LoadBadgeData extends AbstractFixture implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $badge = new Badge();
        $badge->setName('Timide');
        $badge->setActionName('comment');
        $badge->setActionCount(1);
        $manager->persist($badge);

        $badge1 = new Badge();
        $badge1->setName('Pipelette');
        $badge1->setActionName('comment');
        $badge1->setActionCount(2);
        $manager->persist($badge1);

        $manager->flush();
    }
}