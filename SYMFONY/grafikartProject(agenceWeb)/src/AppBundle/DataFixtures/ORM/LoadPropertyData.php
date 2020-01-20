<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Property;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadPropertyData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $property = (new Property())
                ->setTitle($faker->words(3, true))
                ->setAddress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setFloor($faker->numberBetween(0, 15))
                ->setRooms($faker->numberBetween(1, 7))
                ->setBedrooms($faker->numberBetween(1, 9))
                ->setCity($faker->city)
                ->setSurface($faker->numberBetween(20, 350))
                ->setPrice($faker->numberBetween(50000, 500000))
                ->setDescription($faker->sentences(3, true))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1));
            $manager->persist($property);
        }

        $manager->flush();
    }
}