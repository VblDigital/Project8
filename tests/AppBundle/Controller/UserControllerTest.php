<?php


namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    public function setUp()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'Admin',
            'PHP_AUTH_PW'   => '123456',
            ''
        ]);

        return $client;
    }

    public function testUserListActionIfNotLogged()
    {
        $client = static::createClient();
        $client->request('GET', '/users');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testUserListActionIfAdmin()
    {
        $client = $this->setUp();
        $crawler = $client->request('GET', '/users');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testCreateUserIfLogged()
    {
        $client = $this->setUp();
        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'user-'.mt_rand(),
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[email]' => 'email'.mt_rand().'@mail.com',
            'user[roles]' => ['ROLE_USER'],
        ]);

        $client->submit($form);
        $this->assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testEditUserIfLogged()
    {
        $client = $this->setUp();
        $crawler = $client->request('GET', '/users/36/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[roles]' => ['ROLE_ADMIN'],
        ]);

        $client->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
}
