<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function setUp()
    {
        $client = static::createClient(
            [], [
            'PHP_AUTH_USER' => 'Admin',
            'PHP_AUTH_PW'   => '123456',
            ''
            ]
        );

        return $client;
    }

    public function testExpectedRedirectionIfNotLogged()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testDisplayPageIfLogged()
    {
        $client = $this->setUp();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
