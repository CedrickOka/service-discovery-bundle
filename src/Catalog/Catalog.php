<?php
namespace Oka\ServiceDiscoveryBundle\Catalog;

use Oka\ServiceDiscoveryBundle\Exception\CatalogHandlerFactoryNotFoundException;
use Oka\ServiceDiscoveryBundle\LoadBalancer\ServiceLoadBalancer;
use Psr\Cache\CacheItemPoolInterface;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerFactoryInterface;

/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
class Catalog
{
	private $loadBalancer;
	private $cachePool;
	private $loadBalancingAlgorithm;
	private $dsn;
	private $options;
	private $factories;
	
	/**
	 * @var array
	 */
	private $cachedHandlers = [];
	
	public function __construct(ServiceLoadBalancer $loadBalancer, CacheItemPoolInterface $cachePool, string $loadBalancingAlgorithm, string $dsn, array $options = [], iterable $factories = [])
	{
		$this->loadBalancer = $loadBalancer;
		$this->cachePool = $cachePool;
		$this->loadBalancingAlgorithm = $loadBalancingAlgorithm;
		$this->dsn = $dsn;
		$this->options = $options;
		$this->factories = $factories;
	}
	
	public function addHandlerFactory(CatalogHandlerFactoryInterface $factory) :void
	{
		$this->factories[] = $factory;
	}
	
	/**
	 * @throws \Oka\ServiceDiscoveryBundle\Exception\ServiceNotFoundException
	 * @throws \Oka\ServiceDiscoveryBundle\Exception\CatalogHandlerFactoryNotFoundException
	 */
	public function getService(string $serviceName) :Service
	{
		/** @var \Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerFactoryInterface $factory */
		foreach ($this->factories as $factory) {
			if (false === $factory->supports($this->dsn, $this->options)) {
				continue;
			}
			
			$factoryClassName = get_class($factory);
			
			/** @var \Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerInterface $handler */
			if (!$handler = $this->cachedHandlers[$factoryClassName] ?? null) {
				$handler = $factory->createHandler($this->dsn, $this->options);
				$this->cachedHandlers[$factoryClassName] = $handler;
			}
			
			$collection = $handler->getService($serviceName);
			$lastService = $this->cachePool->getItem(sprintf('oka_service_discovery.last_provided_service.%s', $serviceName));
			$service = $this->loadBalancer->execute($this->loadBalancingAlgorithm, $collection, $lastService->get());
			
			$lastService->set($service);
			$this->cachePool->saveDeferred($lastService);
			
			return $service;
		}
		
		throw new CatalogHandlerFactoryNotFoundException(sprintf('No Catalog handler factory was found for DSN "%s"', $this->dsn));
	}
}
