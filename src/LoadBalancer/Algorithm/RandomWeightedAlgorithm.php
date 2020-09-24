<?php
namespace Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;

/**
 *
 * @author Cedrick Oka Baidai <baidai.cedric@veone.net>
 *
 */
class RandomWeightedAlgorithm implements LoadBalancerAlgorithmInterface
{
	public static function getName(): string
	{
		return 'weighted-random';
	}
	
	public function execute(ServiceCollection $collection, Service $lastService = null) :Service
	{
		if (null !== $lastService) {
			$collection = $collection->filter(function(Service $value) use ($lastService) {
				return $value->getUrl() !== $lastService->getUrl();
			});
		}
		
		$weightSum = $collection->reduce(function($carry, Service $item) {
			return $carry + $item->getWeight();
		}, 0);
		
		$randomWeight = rand(0, $weightSum);
		
		/** @var \Oka\ServiceDiscoveryBundle\Catalog\Service $service */
		foreach ($collection as $service) {
			if ($randomWeight < $service->getWeight()) {
				return $service;
			}
			
			$randomWeight -= $service->getWeight();
		}
		
		return $collection->first();
	}
}
