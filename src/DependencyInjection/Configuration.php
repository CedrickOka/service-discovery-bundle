<?php
namespace Oka\ServiceDiscoveryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder('oka_service_discovery');
		/** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode */
		$rootNode = $treeBuilder->getRootNode();
		
		$rootNode
			->beforeNormalization()
				->ifString()
				->then(function (string $dsn) {
					return ['dsn' => $dsn];
				})
			->end()
			->fixXmlConfig('option')
			->addDefaultsIfNotSet()
			->children()
				->scalarNode('logger_id')->defaultNull()->end()
				->scalarNode('cache_id')->defaultValue('cache.app')->end()
				->enumNode('load_balancing_algorithm')
					->values(['round-robin', 'random', 'weighted-round-robin', 'weighted-random'])
					->defaultValue('round-robin')
				->end()
				->scalarNode('dsn')->defaultNull()->end()
				->arrayNode('options')
					->performNoDeepMerging()
					->normalizeKeys(false)
					->treatNullLike([])
					->defaultValue([])
					->prototype('variable')
					->end()
				->end()
			->end();
		
		return $treeBuilder;
	}
}
