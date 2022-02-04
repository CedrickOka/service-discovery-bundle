<?php
namespace Oka\ServiceDiscoveryBundle;

use Oka\ServiceDiscoveryBundle\DependencyInjection\Compiler\CachePoolServicePass;
use Oka\ServiceDiscoveryBundle\DependencyInjection\Compiler\CatalogHandlerFactoriesPass;
use Oka\ServiceDiscoveryBundle\DependencyInjection\Compiler\LoadBalancerAlgorithmsPass;
use Oka\ServiceDiscoveryBundle\DependencyInjection\Compiler\LoggerServicePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class OkaServiceDiscoveryBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
    
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		
		$container->addCompilerPass(new LoggerServicePass());
		$container->addCompilerPass(new CachePoolServicePass());
		$container->addCompilerPass(new LoadBalancerAlgorithmsPass());
		$container->addCompilerPass(new CatalogHandlerFactoriesPass());
	}
}
