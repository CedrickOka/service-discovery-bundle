<?php

namespace Oka\ServiceDiscoveryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class CatalogHandlerFactoriesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('oka_service_discovery.catalog');

        foreach ($container->findTaggedServiceIds('oka_service_discovery.catalog_handler_factory') as $id => $tags) {
            $definition->addMethodCall('addHandlerFactory', [new Reference($id)]);
        }
    }
}
