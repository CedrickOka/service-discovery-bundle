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
class LoggerServicePass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		if (null === ($loggerId = $container->getParameter('oka_service_discovery.logger_id'))) {
			return;
		}
		
		if (false === $container->hasDefinition($loggerId)) {
			return;
		}
		
		$consulHandlerFactory = $container->getDefinition('oka_service_discovery.consul_catalog_handler_factory');
		$consulHandlerFactory->replaceArgument(0, new Reference($loggerId));
	}
}
