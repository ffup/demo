<?php

namespace Acme\BoardBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ModuleControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/board/');
        
        // var_dump($client->getResponse()->getContent());
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Modules")')->count()
        );
    }

}
