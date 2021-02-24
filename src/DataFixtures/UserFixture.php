<?php

namespace App\DataFixtures;

use App\Entity\UserOld;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create();

        for($i = 0; $i<10; $i++) {
            $user = new UserOld();
            $user->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setBirthdate($faker->date())
                ->setAvatar($faker->imageUrl(150, 150))
                ->setMail($faker->email)
                ->setPassword("")
                ->setAddress($faker->address)
                ->setGender("")
                ->setAccountStatus("pending")
                ->setCreatedAt(new \DateTime())
                ->setLastConnection(new \DateTime());
            $manager->persist($user);
        }

        $manager->flush();
    }
}
