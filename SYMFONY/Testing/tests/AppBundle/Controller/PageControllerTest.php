<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Client;

class PageControllerTest extends WebTestCase
{
    /**
     * @var Client $client
     */
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testHelloPage()
    {
        $this->client->request('GET', '/hello');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testH1HelloPage()
    {
        $crawler = $this->client->request('GET', '/hello');
        $this->assertSame('Bienvenue sur mon site', $crawler->filter('h1')->text());
    }

    public function testAuthPageIsRestricted()
    {
        $this->client->request('GET', '/auth');
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testRedirectToLogin()
    {
        $this->client->request('GET','/auth');
        $this->assertTrue($this->client->getResponse()->isRedirect('http://localhost/login'));
    }

    public function testMailSendEmail()
    {
        $this->client->enableProfiler();
        $this->client->request('GET','/mail');
        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $mailCollector->getMessageCount());
    }
}