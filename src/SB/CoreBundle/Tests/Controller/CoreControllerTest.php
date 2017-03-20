<?php

namespace SB\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CoreControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    protected function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = 'secured_area';

        $token = new UsernamePasswordToken('user', null, $firewall, array('ROLE_USER'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    protected function visitorOnIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(1, $crawler->filter('title:contains("Accueil")')->count()); // Vérifie si le title de la page est "Accueil"
        $this->assertEquals(1, $crawler->filter('nav a.dropdown-toggle:contains("Connexion")')->count()); // Vérifie si la nav bar contient le dropdown "Connexion"
        $this->assertNotEquals(1, $crawler->filter('nav a.dropdown-toggle:contains("Déconnexion")')->count()); // Vérifie si la nav bar ne contient PAS le dropdown "Déconnexion"
    }

    protected function memberOnIndex()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(0, $crawler->filter('nav a.dropdown-toggle:contains("Déconnexion")')->count());
    }

    public function testIndex()
    {
        $this->memberOnIndex();
        $this->visitorOnIndex();
    }
}