<?php

namespace UMRA\Bundle\MemberBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');
    }

    public function testRenew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/renew');
    }

}
