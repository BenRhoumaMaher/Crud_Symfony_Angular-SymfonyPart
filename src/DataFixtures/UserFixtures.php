<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername("maher");
        $hashedPassword = password_hash("Maher123.", PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $manager->flush();
    }
}