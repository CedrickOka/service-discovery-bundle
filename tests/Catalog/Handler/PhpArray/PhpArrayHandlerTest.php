<?php
namespace Oka\ServiceDiscoveryBundle\Tests\Catalog\Handler\PhpArray;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerInterface;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\PhpArray\PhpArrayHandler;
use PHPUnit\Framework\TestCase;

class PhpArrayHandlerTest extends TestCase
{
	/**
	 * @covers
	 */
	public function testItIsAHandler()
	{
		$handler = $this->getHandler();
		
		$this->assertInstanceOf(CatalogHandlerInterface::class, $handler);
	}
	
	/**
	 * @covers
	 */
	public function testGetService()
	{
		$handler = $this->getHandler(['localhost' => new ServiceCollection(new Service('127.0.0.1', 80))]);
		$serviceCollection = $handler->getService('localhost');
		
		$this->assertCount(1, $serviceCollection);
		$this->assertEquals('http://127.0.0.1:80', $serviceCollection->get(0)->getUrl());
	}
	
	private function getHandler(array $serviceCollectionMap = []): PhpArrayHandler
	{
		return new PhpArrayHandler($serviceCollectionMap);
	}
}
