<?php
namespace Oka\ServiceDiscoveryBundle\Catalog\Handler\Consul;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerInterface;
use Oka\ServiceDiscoveryBundle\Exception\ServiceNotFoundException;
use SensioLabs\Consul\Services\CatalogInterface;

/**
 *
 * @author Cedrick Oka Baidai <baidai.cedric@veone.net>
 *
 */
class ConsulHandler implements CatalogHandlerInterface
{
	private $catalog;
	
	public function __construct(CatalogInterface $catalog)
	{
		$this->catalog = $catalog;
	}
	
	public function getService(string $service): ServiceCollection
	{
		/** @var \SensioLabs\Consul\ConsulResponse $response */
		$response = $this->catalog->service($service);
		$services = json_decode($response->getBody(), true);
		
		if (true === is_array($services)) {
			$serviceCollection = new ServiceCollection();
			
			foreach ($services as $service) {
				if (false === isset($service['ServiceAddress']) && false === isset($service['ServicePort'])) {
					continue;
				}
				
				$meta = $service['ServiceMeta'] ?? [];
				$serviceCollection->add(new Service($service['ServiceAddress'], $service['ServicePort'], $meta['scheme'] ?? 'http', $meta['weight'] ?? 1));
			}
			
			return $serviceCollection;
		}
		
		throw new ServiceNotFoundException(sprintf('You have requested a non-existent service "%s".', $service));
	}
}
