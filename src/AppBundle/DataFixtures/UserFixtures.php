<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) 
        {
            $user = new User();
            $user->setFirstname($faker->firstname);
            $user->setLastname($faker->lastname);

            $manager->persist($user);
        }

        $manager->flush();
    }
}