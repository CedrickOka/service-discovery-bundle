<?php
namespace Oka\ServiceDiscoveryBundle\DependencyInjection;

use Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerFactoryInterface;
use Oka\ServiceDiscoveryBundle\LoadBalancer\Algorithm\LoadBalancerAlgorithmInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
class OkaServiceDiscoveryExtension extends Extension
{
	/**
	 * {@inheritDoc}
	 */
	public function load(array $configs, ContainerBuilder $container)
	{
		$container
			->registerForAutoconfiguration(CatalogHandlerFactoryInterface::class)
			->addTag('oka_service_discovery.catalog_handler_factory');
		
		$container
			->registerForAutoconfiguration(LoadBalancerAlgorithmInterface::class)
			->addTag('oka_service_discovery.load_balancer_algorithm');
			
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);
		
		$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		$loader->load('services.yml');
		
		$container->setParameter('oka_service_discovery.cache_id', $config['cache_id']);
		$container->setParameter('oka_service_discovery.logger_id', $config['logger_id']);
		
		$definition = $container->getDefinition('oka_service_discovery.catalog');
		$definition->replaceArgument(2, $config['load_balancing_algorithm']);
		$definition->replaceArgument(3, $config['dsn'] ?? '');
		$definition->replaceArgument(4, $config['options']);
	}
}

