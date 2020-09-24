<?php
namespace Oka\ServiceDiscoveryBundle\Catalog\Handler;

use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;

/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
interface CatalogHandlerInterface
{
	public function getService(string $service) :ServiceCollection;
}
