<?php
namespace Oka\ServiceDiscoveryBundle\Catalog\Handler\PhpArray;

use Oka\ServiceDiscoveryBundle\Catalog\Service;
use Oka\ServiceDiscoveryBundle\Catalog\ServiceCollection;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerFactoryInterface;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerInterface;

/**
 *
 * @author Cedrick Oka Baidai <baidai.cedric@veone.net>
 *
 */
class PhpArrayHandlerFactory implements CatalogHandlerFactoryInterface
{
	public function supports(string $dsn, array $options): bool
	{
		return 0 === strpos($dsn, 'php://array');
	}
	
	/**
	 * Creates a handler based on the DSN and options.
	 *
	 * Available options:
	 *
	 *   * logger_id: The logger service id (Default: logger)
	 *   * Guzzle client all options availables
	 */
	public function createHandler(string $dsn, array $options): CatalogHandlerInterface
	{
		$map = [];
		
		foreach ($options['services'] as $key => $items) {
			if (false === is_array($items)) {
				throw new \InvalidArgumentException(sprintf('The service collection "%s" must be of type array "%s" given.', $key, gettype($items)));
			}
			
			$services = new ServiceCollection();
			
			foreach ($items as $item) {
				if (false === is_array($item)) {
					throw new \InvalidArgumentException(sprintf('The service collection element must be of type array "%s" given.', gettype($item)));
				}
				
				$keys = array_keys($item);
				
				if ($diff = array_diff($keys, ['host', 'port', 'scheme', 'weight'])) {
					throw new \InvalidArgumentException(sprintf('The following options "%s" are not availables in service defintion "%s".', implode(',', $diff), $key));
				}
				
				if ($diff = array_diff(['host', 'port'], $keys)) {
					throw new \InvalidArgumentException(sprintf('The following options "%s" are required in service defintion "%s".', implode(',', $diff), $key));
				}
				
				$services->add(new Service($item['host'], $item['port'], $item['scheme'] ?? 'http', $item['weight'] ?? 1));
			}
			
			$map[$key] = $services; 
		}
		
		return new PhpArrayHandler($map);
	}
}
