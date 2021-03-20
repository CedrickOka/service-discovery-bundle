<?php
namespace Oka\ServiceDiscoveryBundle\Catalog\Handler\PhpArray;

use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerInterface;
use Oka\ServiceDiscoveryBundle\Exception\ServiceNotFoundException;

/**
 *
 * @author Cedrick Oka Baidai <baidai.cedric@veone.net>
 *
 */
class PhpArrayHandler implements CatalogHandlerInterface
{
	private $serviceCollectionMap;
	
	public function __construct(array $serviceCollectionMap)
	{
		$this->serviceCollectionMap = $serviceCollectionMap;
	}
	
	public function getServices(): iterable
	{
		return $this->serviceCollectionMap;
	}
	
	public function getService(string $service): ServiceCollection
	{
		if (false === isset($this->serviceCollectionMap[$service])) {
			throw new ServiceNotFoundException(sprintf('You have requested a non-existent service "%s".', $service));
		}
		
		return $this->serviceCollectionMap[$service];
	}
}
