<?php

namespace Acme\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BoardControllerTest extends WebTestCase
{
    public function testThread()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/thread');
    }

    public function testComment()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/comment');
    }

}
