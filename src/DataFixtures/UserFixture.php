<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create();

        for($i = 0; $i<10; $i++) {
            $files = glob('/tmp' . '/*.*'); // TODO : Changer ca et faire un upload de fichier
            $file = array_rand($files);
            $path = $files[$file];
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $user = new User();
            $user->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setBirthdate(new \DateTime())
                ->setUsername($faker->userName)
                ->setAvatar($base64)
                ->setMail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, $faker->password))
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
