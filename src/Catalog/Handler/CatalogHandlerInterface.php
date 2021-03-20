<?php
namespace Oka\ServiceDiscoveryBundle\Catalog\Handler;

use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;

/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
interface CatalogHandlerInterface
{
	/**
	 * @return ServiceCollection[]
	 */
	public function getServices(): iterable;
	
	public function getService(string $service): ServiceCollection;
}
