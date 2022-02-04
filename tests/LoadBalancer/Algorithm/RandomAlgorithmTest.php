<?php
namespace Oka\ServiceDiscoveryBundle\Tests\LoadBalancer\Algorithm;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;
use Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm\RandomAlgorithm;
use PHPUnit\Framework\TestCase;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class RandomAlgorithmTest extends TestCase
{
	/**
	 * @covers
	 */
	public function testExecute()
	{
		$algorithm = new RandomAlgorithm();
		$collection = new ServiceCollection(
			new Service('127.0.0.1'), 
			new Service('127.0.0.2'), 
			new Service('127.0.0.3'), 
			new Service('127.0.0.4')
		);
		
		$service1 = $algorithm->execute($collection);
		$service2 = $algorithm->execute($collection, $service1);
		
		$this->assertNotEquals($service1->getUrl(), $service2->getUrl());
	}
}
