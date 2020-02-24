<?php


namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginPage()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLoginCheck()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->count());
    }

    public function testLogout()
    {
        $client = static::createClient();

        $client->request('GET', '/logout');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
