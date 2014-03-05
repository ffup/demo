<?php

namespace Acme\BoardBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RateControllerTest extends WebTestCase
{
    public function testIncrease()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/increase');
    }

}
