<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{ 
        private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    // ...
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@admin.com');

        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);

        // $user->setRoles(['admin']);

        $manager->persist($user);
        $manager->flush();
    }
}
