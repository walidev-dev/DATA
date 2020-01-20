<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class MockTest extends TestCase
{
    public function testExemple()
    {
        $client = $this
            ->getMockBuilder('GuzzleHttp\Client')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $client
            ->method('get')
            ->willReturn('foo');

        $this->assertSame('foo', $client->get('blabla'));

        $this->assertInstanceOf(Client::class, $client);
    }
}
