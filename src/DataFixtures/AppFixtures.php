<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
# on va récupérer notre entité User
use App\Entity\User; 

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        # instanciation d'un User
        $user = new User();

        # utilisation du $manager pour mettre le user en mémoire
        $manager->persist($user);

        $manager->flush();
    }
}
