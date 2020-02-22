<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    public function setUp()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'Admin',
            'PHP_AUTH_PW'   => '123456',
        ]);

        return $client;
    }

    public function testTaskListActionIfNotLogged()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testCreateTaskIfLogged()
    {
        $client = $this->setUp();
        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'New title',
            'task[content]' => 'New content',
        ]);

        $client->submit($form);
        $this->assertSame(
            302,
            $client->getResponse()->getStatusCode()
        );

        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testEditTaskIfLogged()
    {
        $client = $this->setUp();
        $crawler = $client->request('GET', '/tasks/1/edit');
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'New title for the Task',
        ]);
        $client->submit($form);

        $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testToogleTaskActionIfLogged()
    {
        $client = $this->setUp();
        $client->request('GET', '/tasks/1/toggle');

        $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testDeleteTaskIfLogged()
    {
        $client = $this->setUp();
        $client->request('GET', '/tasks/1/delete');

        $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
}
