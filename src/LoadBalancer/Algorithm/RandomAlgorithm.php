<?php
namespace Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;

/**
 * @author Cedrick Oka Baidai <baidai.cedric@veone.net>
 */
class RandomAlgorithm implements LoadBalancerAlgorithmInterface
{
	public static function getName(): string
	{
		return 'random';
	}

	public function execute(ServiceCollection $collection, Service $lastService = null) :Service
	{
		if (null !== $lastService) {
			$collection = $collection->filter(function(Service $value) use ($lastService) {
				return $value->getUrl() !== $lastService->getUrl();
			});
		}
		
		$randomIndex = rand(0, ($collection->count() - 1));
		
		return $collection->get($randomIndex);
	}
}
