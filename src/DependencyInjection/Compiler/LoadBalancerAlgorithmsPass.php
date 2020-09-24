<?php
namespace Oka\ServiceDiscoveryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
class LoadBalancerAlgorithmsPass implements CompilerPassInterface
{	
	public function process(ContainerBuilder $container)
	{
		$definition = $container->getDefinition('oka_service_discovery.service_load_balancer');
		
		foreach ($container->findTaggedServiceIds('oka_service_discovery.load_balancer_algorithm') as $id => $tags) {
			$definition->addMethodCall('addAlgorithm', [new Reference($id)]);
		}
	}
}
