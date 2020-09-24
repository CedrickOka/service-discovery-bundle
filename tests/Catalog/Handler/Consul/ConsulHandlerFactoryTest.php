<?php
namespace Oka\ServiceDiscoveryBundle\Tests\Catalog\Handler\Consul;

use Oka\ServiceDiscoveryBundle\Catalog\Handler\Consul\ConsulHandler;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\Consul\ConsulHandlerFactory;
use PHPUnit\Framework\TestCase;
use SensioLabs\Consul\ServiceFactory;
use SensioLabs\Consul\Services\CatalogInterface;

class ConsulHandlerFactoryTest extends TestCase
{
	/**
	 * @covers
	 */
	public function testSupportsOnlyConsulHandler()
	{
		$factory = new ConsulHandlerFactory();
		
		$this->assertTrue($factory->supports('consul://127.0.0.1:8500', []));
		$this->assertTrue($factory->supports('consul-tls://127.0.0.1:8500', []));
		$this->assertFalse($factory->supports('invalid-dsn://127.0.0.1:8500', []));
	}
	
	/**
	 * @covers
	 */
	public function testItCreatesTheHandler()
	{
		$factory = new ConsulHandlerFactory();
		$serviceFactory = new ServiceFactory(['base_uri' => 'http://127.0.0.1:8500']);
		$expectedHandler = new ConsulHandler($serviceFactory->get(CatalogInterface::class));
		
		$this->assertEquals($expectedHandler, $factory->createHandler('consul://127.0.0.1:8500', []));
	}
}
