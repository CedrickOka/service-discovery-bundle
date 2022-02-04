<?php
namespace Oka\ServiceDiscoveryBundle\Tests\LoadBalancer\Algorithm;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;
use Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm\RoundRobinWeightedAlgorithm;
use PHPUnit\Framework\TestCase;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class RoundRobinWeightedAlgorithmTest extends TestCase
{
	/**
	 * @covers
	 */
	public function testExecute()
	{
		$algorithm = new RoundRobinWeightedAlgorithm();
		$collection = new ServiceCollection(
			new Service('127.0.0.1', 80, 'http', 5), 
			new Service('127.0.0.2', 80, 'http', 3), 
			new Service('127.0.0.3', 80, 'http', 8), 
			new Service('127.0.0.4', 80, 'http', 4)
		);
		
		$service = $algorithm->execute($collection);
		$this->assertEquals('http://127.0.0.3:80', $service->getUrl());
		
		$service = $algorithm->execute($collection, $service);
		$this->assertEquals('http://127.0.0.1:80', $service->getUrl());
		
		$service = $algorithm->execute($collection, $service);
		$this->assertEquals('http://127.0.0.4:80', $service->getUrl());
		
		$service = $algorithm->execute($collection, $service);
		$this->assertEquals('http://127.0.0.2:80', $service->getUrl());
		
		$service = $algorithm->execute($collection, $service);
		$this->assertEquals('http://127.0.0.3:80', $service->getUrl());
	}
}
