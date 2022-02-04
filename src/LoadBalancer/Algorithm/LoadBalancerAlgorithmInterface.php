<?php
namespace Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;

/**
 * @author Cedrick Oka Baidai <baidai.cedric@veone.net>
 */
interface LoadBalancerAlgorithmInterface
{
	/**
	 * Get the load balancer algoithm name
	 */
	public static function getName() :string;
	
	/**
	 * Execute service selection agorithm
	 */
	public function execute(ServiceCollection $collection, Service $lastService = null) :Service;
}
