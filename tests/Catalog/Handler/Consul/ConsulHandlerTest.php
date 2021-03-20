<?php
namespace Oka\ServiceDiscoveryBundle\Tests\Catalog\Handler\Consul;

use Oka\ServiceDiscoveryBundle\Catalog\Handler\Consul\ConsulHandler;
use PHPUnit\Framework\TestCase;
use SensioLabs\Consul\ConsulResponse;
use SensioLabs\Consul\Services\CatalogInterface;

class ConsulHandlerTest extends TestCase
{
	/**
	 * @covers
	 */
	public function testItIsAHandler()
	{
		$handler = $this->getHandler();
		
		$this->assertInstanceOf(ConsulHandler::class, $handler);
	}
	
	/**
	 * @covers
	 */
	public function testGetService()
	{
		$handler = $this->getHandler([['ServiceAddress' => '127.0.0.1', 'ServicePort' => 80]]);
		$serviceCollection = $handler->getService('localhost');
		
		$this->assertCount(1, $serviceCollection);
		$this->assertEquals('http://127.0.0.1:80', $serviceCollection->get(0)->getUrl());
	}
	
	private function getHandler(array $services = []): ConsulHandler
	{
		$catalog = $this->createMock(CatalogInterface::class);
		$catalog->method('service')
				->with('localhost')
				->willReturn(new ConsulResponse([], json_encode($services)));
		
		return new ConsulHandler($catalog);
	}
}
