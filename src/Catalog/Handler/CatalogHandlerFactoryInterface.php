<?php
namespace Oka\ServiceDiscoveryBundle\Catalog\Handler;

/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
interface CatalogHandlerFactoryInterface
{
	/**
	 * Checks if catalog handler factory supports dsn and options
	 */
	public function supports(string $dsn, array $options): bool;
	
	/**
	 * Create a catalog handler
	 */
	public function createHandler(string $dsn, array $options): CatalogHandlerInterface;
}
