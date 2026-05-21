<?php

namespace Oka\ServiceDiscoveryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class LoadBalancerAlgorithmsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('oka_service_discovery.service_load_balancer');

        foreach ($container->findTaggedServiceIds('oka_service_discovery.load_balancer_algorithm') as $id => $tags) {
            $definition->addMethodCall('addAlgorithm', [new Reference($id)]);
        }
    }
}
