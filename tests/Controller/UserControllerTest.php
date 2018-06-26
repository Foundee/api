<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
     public function testCheckEmailBeforeRegistration()
     {
         $client = static::createClient();

         $client->request('GET', '/users/checkEmail', ['email' => 'example@ęźample.com']);

         $this->assertEquals(400, $client->getResponse()->getStatusCode());
     }
}
