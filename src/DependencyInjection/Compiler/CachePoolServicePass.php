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
class CachePoolServicePass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		if (null === ($cacheId = $container->getParameter('oka_service_discovery.cache_id'))) {
			return;
		}
		
		if (false === $container->hasDefinition($cacheId)) {
			return;
		}
		
		$definition = $container->getDefinition('oka_service_discovery.catalog');
		$definition->replaceArgument(1, new Reference($cacheId));
	}
}
