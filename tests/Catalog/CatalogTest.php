<?php
namespace Oka\ServiceDiscoveryBundle\Tests\Catalog;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
class CatalogTest extends KernelTestCase
{
	/**
	 * @covers
	 */
	public function testGetService()
	{
		static::bootKernel();
		
		/** @var \Oka\ServiceDiscoveryBundle\Catalog\Catalog $catalog */
		$catalog = static::$container->get('oka_service_discovery.catalog');
		$service = $catalog->getService('localhost');
		
		$this->assertInstanceOf(Service::class, $service);
		$this->assertEquals('http://127.0.0.1:80', $service->getUrl());
	}
}
