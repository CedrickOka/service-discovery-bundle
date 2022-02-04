<?php
namespace Oka\ServiceDiscoveryBundle\Tests\LoadBalancer;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class ServiceLoadBalancerTest extends KernelTestCase
{
	/**
	 * @covers
	 */
	public function testExecute()
	{
		static::bootKernel();
		
		/** @var \Oka\ServiceDiscoveryBundle\LoadBalancer\ServiceLoadBalancer $loadBalancer */
		$loadBalancer = static::$container->get('oka_service_discovery.service_load_balancer');
		$collection = new ServiceCollection(
			new Service('127.0.0.1'),
			new Service('127.0.0.2'),
			new Service('127.0.0.3'),
			new Service('127.0.0.4')
		);
		
		$service = $loadBalancer->execute('round-robin', $collection);
		
		$this->assertInstanceOf(Service::class, $service);
		$this->assertEquals('http://127.0.0.1:80', $service->getUrl());
	}
}
