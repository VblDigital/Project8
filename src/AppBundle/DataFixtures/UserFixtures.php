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
        $user->setUsername("Admin");
        $user->setEmail("admin@user.com");
        $user->setRoles(['ROLE_ADMIN']);
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $user = new User();
        $user->setUsername("Anonymous");
        $user->setEmail("anonymous");
        $user->setRoles(['ROLE_USER']);
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);
        $this->addReference('anonymous', $user);

        $user = new User();
        $user->setUsername("Toto");
        $user->setEmail("toto@user.com");
        $user->setRoles(['ROLE_USER']);
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $user = new User();
        $user->setUsername("Tutu");
        $user->setEmail("tutu@user.com");
        $user->setRoles(['ROLE_USER']);
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $manager->flush();
    }
}