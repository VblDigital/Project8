<?php


namespace Tests\AppBundle\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccessDeniedHandlerTest extends WebTestCase
{
    public function setUp()
    {
        $client = static::createClient(
            [], [
            'PHP_AUTH_USER' => 'Toto',
            'PHP_AUTH_PW'   => '123456',
            ]
        );

        return $client;
    }

    public function testHandle()
    {
        $client = $this->setUp();

        $client->request('GET', 'users/create');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $this->assertContains('L\'accès à cette page est restreint',  $client->getResponse()->getContent());
    }
}
