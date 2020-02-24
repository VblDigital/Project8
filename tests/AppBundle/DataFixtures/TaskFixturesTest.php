<?php


namespace Tests\AppBundle\DataFixtures;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class TaskFixturesTest extends WebTestCase
{
    use FixturesTrait;

    public function testLoad()
    {
        $this->loadFixtures();
        $this->loadFixtures(
            array(
            'AppBundle\DataFixtures\TaskFixtures',
            'AppBundle\DataFixtures\UserFixtures'
            )
        );

        $client = $this->createClient();
        $crawler = $client->request('GET', '/users');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }
}
