<?php
namespace Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;

/**
 *
 * @author Cedrick Oka Baidai <baidai.cedric@veone.net>
 *
 */
class RoundRobinWeightedAlgorithm implements LoadBalancerAlgorithmInterface
{
	public static function getName(): string
	{
		return 'weighted-round-robin';
	}

	public function execute(ServiceCollection $collection, Service $lastService = null) :Service
	{
		$collection->sort(function(Service $a, Service $b) {
			if ($a->getWeight() === $b->getWeight()) {
				return 0;
			}
			
			return $a->getWeight() < $b->getWeight() ? 1 : -1;
		});
		
		if (null === $lastService || null === ($index = $collection->indexOf($lastService))) {
			return $collection->first();
		}
		
		return $collection->get(1 === ($collection->count() - $index) ? 0 : $index + 1);
	}
}
