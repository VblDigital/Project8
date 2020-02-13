<?php


namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @return array
     */
    public function getDependencies ()
    {
        return array(
            UserFixtures::class);
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 20; $i++) {
            $task = new Task();
            $task->setTitle('Tâche numéro '.$i);
            $task->setContent('je suis la ' . $i . 'ème tâche.');
            $manager->persist($task);
        }

        $manager->flush();
    }
}