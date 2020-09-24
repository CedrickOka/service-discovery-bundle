<?php
namespace Oka\ServiceDiscoveryBundle\LoadBalancer;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;
use Oka\ServiceDiscoveryBundle\Exception\LoadBalancerAlgorithmNotFoundException;
use Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm\LoadBalancerAlgorithmInterface;

/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
class ServiceLoadBalancer
{
	private $algorithms;
	
	public function __construct(iterable $algorithms = [])
	{
		$this->algorithms = $algorithms;
	}
	
	public function addAlgorithm(LoadBalancerAlgorithmInterface $algorithm) :void
	{
		$this->algorithms[] = $algorithm;
	}
	
	public function execute(string $algorithmName, ServiceCollection $collection, Service $lastService = null) :Service
	{
		/** @var \Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm\LoadBalancerAlgorithmInterface $algorithm */
		foreach ($this->algorithms as $algorithm) {
			if ($algorithm::getName() !== $algorithmName) {
				continue;
			}
			
			return $algorithm->execute($collection, $lastService);
		}
		
		throw new LoadBalancerAlgorithmNotFoundException(sprintf('The load balancing algorithm "%s" implementation is not defined.', $algorithmName));
	}
}
