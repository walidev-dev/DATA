<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityControllerTest extends WebTestCase
{
    /**
     * @var Client $client
     */
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }
    
    public function testDisplayLoginPage()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertSame('Se connecter', $crawler->filter('h1')->text());
    }

    public function testLoginWithBadCredentials()
    {
        $this->client->request('POST', '/login', [
            '_username' => 'badUsername',
            '_password' => 'badPassword'
        ]);

        $this->assertTrue($this->client->getResponse()->isRedirect('http://localhost/login'));
        $this->client->followRedirect();
        $this->assertEquals(1, $this->client->getCrawler()->filter('.alert.alert-danger')->count());
    }

    public function testSuccessFullLogin()
    {
        $crawler = $this->client->request('GET','/login');
        $form = $crawler->selectButton('Connexion')->form([
            '_username' => 'user1@domain.fr',
            '_password' => '0000'
        ]);
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('http://localhost/auth'));
        $this->client->followRedirect();
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testSuccessLoginWithPostRequest()
    {
        $this->client->request('POST', '/login', [
            '_username' => 'user0@domain.fr',
            '_password' => '0000'
        ]);
        $this->assertTrue($this->client->getResponse()->isRedirect('http://localhost/auth'));
        $this->client->followRedirect();
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testSuccessLoginWithCookie()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/auth');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Bienvenue sur mon site', $crawler->filter('h1')->text());
    }

    private function logIn()
    {
        $user = $this->client->getContainer()->get('doctrine')->getRepository(User::class)->find(1);
        $session = $this->client->getContainer()->get('session');
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function testAdminRequireAdminRole()
    {
        $this->logIn();

        $this->client->request('GET', '/admin');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }

}