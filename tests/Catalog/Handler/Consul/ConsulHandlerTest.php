<?php

namespace Oka\ServiceDiscoveryBundle\Tests\Catalog\Handler\Consul;

use Consul\Client;
use Consul\Services\Catalog;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\Consul\ConsulHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class ConsulHandlerTest extends TestCase
{
    private ?ConsulHandler $handler = null;

    /**
     * @covers
     */
    public function testItIsAHandler()
    {
        $this->assertInstanceOf(ConsulHandler::class, $this->handler);
    }

    /**
     * @covers
     *
     * @depends testItIsAHandler
     */
    public function testGetService()
    {
        $serviceCollection = $this->handler->getService('localhost');

        $this->assertCount(1, $serviceCollection);
        $this->assertEquals('http://127.0.0.1:80', $serviceCollection->get(0)->getUrl());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $httpClient = new MockHttpClient(function (string $method, string $url, array $options = []) {
            return new MockResponse(
                <<<EOF
[
    {
        "ServiceAddress": "127.0.0.1",
        "ServicePort": 80
    }
]
EOF,
                ['response_headers' => ['Content-Type' => 'application/json']]
            );
        }, 'http://127.0.0.1:8500');

        $this->handler = new ConsulHandler(new Catalog(new Client(client: $httpClient)));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->handler = null;
    }
}
