<?php

namespace Tests\AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Security\GithubUserProvider;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GithubUserProviderTest extends TestCase
{
    /**
     * @var Client $client
     */
    private $client;

    /**
     * @var Serializer $serializer
     */
    private $serializer;

    public function setUp()
    {
        $responseInterface = $this
            ->getMockBuilder(ResponseInterface::class)
            ->getMock();

        $streamedResponse = $this
            ->getMockBuilder(StreamInterface::class)
            ->getMock();

        $this->client = $this
            ->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $this->serializer = $this
            ->getMockBuilder(Serializer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $responseInterface
            ->method('getBody')
            ->willReturn($streamedResponse);

        $this->client
            ->method('get')
            ->willReturn($responseInterface);

    }

    public function tearDown()
    {
        $this->client = null;
        $this->serializer = null;
    }

    public function testLoadUserByUsernameReturningAUser()
    {
        $userData = [
            'login' => 'Username-login',
            'name' => 'Username-name',
            'email' => 'Username-email',
            'avatar_url' => 'Username-avatar_url',
            'html_url' => 'Username-html_url'
        ];

        $this->serializer
            ->method('deserialize')
            ->willReturn($userData);


        $GithubUserProvider = new GithubUserProvider($this->client, $this->serializer);

        $expectedUser = $GithubUserProvider->loadUserByUsername('username');

        $user = new User(
            $userData['login'],
            $userData['name'],
            $userData['email'],
            $userData['avatar_url'],
            $userData['html_url']
        );

        $this->assertEquals($expectedUser, $user);

        $this->assertInstanceOf(User::class, $expectedUser);

    }

    public function testLoadUserByUsernameThrowingException()
    {
        $this->serializer
            ->method('deserialize')
            ->willReturn([]);

        $this->expectException(\LogicException::class);

        $GithubUserProvider = new GithubUserProvider($this->client, $this->serializer);

        $GithubUserProvider->loadUserByUsername('username');


    }
}