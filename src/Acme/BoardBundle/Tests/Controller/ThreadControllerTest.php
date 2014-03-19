<?php

namespace Acme\BoardBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ThreadControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken('testuser', null, $firewall, array('ROLE_USER'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }


    public function testIndex()
    {
        $this->logIn();
        
        $crawler = $this->client->request('GET', '/board/thread/create?module_id=2');
        
        $form = $crawler->selectButton('Create')->form();
                
        $form['acme_boardbundle_thread[title]'] = 'title11111111';
        $form['acme_boardbundle_thread[content]'] = 'content1111111';        

        // submit the form
        $crawler = $this->client->submit($form);
        
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        // $this->assertGreaterThan(0, $crawler->filter('html:contains("Hello Fabien")')->count());

    }

}
