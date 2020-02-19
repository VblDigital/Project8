<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class TaskTest
 * @package Tests\AppBundle\Entity
 */
class TaskTest extends KernelTestCase
{
    /**
     * @param $title
     * @param $content
     * @return Task
     * @throws \Exception
     */
    public function getTaskEntity($title, $content): Task
    {
        $task = new Task();
        $task->setTitle($title);
        $task->setContent($content);

        return $task;
    }

    /**
     * @param Task $task
     * @param int $number
     */
    public function assertHasErrors(Task $task, int $number = 0)
    {
        $error = self::bootKernel()->getContainer()->get('validator')->validate($task);
        $this->assertCount($number, $error);
    }

    /**
     * @throws \Exception
     */
    public function testValidTaskEntity()
    {
        $this->assertHasErrors($this->getTaskEntity(
            'A faire en premier',
            'Je dois faire cette tâche en premier'),
            0);
    }

    /**
     * @throws \Exception
     */
    public function testInvalidTitle()
    {
        $this->assertHasErrors($this->getTaskEntity(
            '',
            'Je dois faire cette tâche en premier'),
            1);
    }

    /**
     * @throws \Exception
     */
    public function testBlankEmail()
    {
        $this->assertHasErrors($this->getTaskEntity(
            'A faire en premier',
            ''),
            1);
    }
}
