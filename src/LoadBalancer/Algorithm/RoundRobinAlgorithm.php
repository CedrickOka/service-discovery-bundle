<?php
namespace Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;

/**
 *
 * @author Cedrick Oka Baidai <baidai.cedric@veone.net>
 *
 */
class RoundRobinAlgorithm implements LoadBalancerAlgorithmInterface
{
	public static function getName(): string
	{
		return 'round-robin';
	}

	public function execute(ServiceCollection $collection, Service $lastService = null) :Service
	{
		if (null === $lastService || null === ($index = $collection->indexOf($lastService))) {
			return $collection->first();
		}
		
		return $collection->get(1 === ($collection->count() - $index) ? 0 : $index + 1);
	}
}
