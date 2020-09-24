<?php
namespace Oka\ServiceDiscoveryBundle\Tests\Catalog\Handler\PhpArray;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\PhpArray\PhpArrayHandler;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\PhpArray\PhpArrayHandlerFactory;
use PHPUnit\Framework\TestCase;

class PhpArrayHandlerFactoryTest extends TestCase
{
	/**
	 * @covers
	 */
	public function testSupportsOnlyConsulHandler()
	{
		$factory = new PhpArrayHandlerFactory();
		
		$this->assertTrue($factory->supports('php://array', []));
		$this->assertFalse($factory->supports('invalid-dsn://127.0.0.1:8500', []));
	}
	
	/**
	 * @covers
	 */
	public function testItCreatesTheHandler()
	{
		$factory = new PhpArrayHandlerFactory();
		$expectedHandler = new PhpArrayHandler(['localhost' => new ServiceCollection(new Service('127.0.0.1', 80))]);
		
		$this->assertEquals($expectedHandler, $factory->createHandler('consul://127.0.0.1:8500', ['services' => ['localhost' => [['host' => '127.0.0.1', 'port' => 80]]]]));
	}
}
