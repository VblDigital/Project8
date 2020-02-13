<?php


namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("Toto");
        $user->setEmail("toto@user.com");
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $user = new User();
        $user->setUsername("Tutu");
        $user->setEmail("tutu@user.com");
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $manager->flush();
    }
}