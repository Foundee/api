<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testCheckLoginBeforeRegistration()
    {
        $client = static::createClient();

        $client->request('GET', '/users/checkLogin', ['login' => 'admin']);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
