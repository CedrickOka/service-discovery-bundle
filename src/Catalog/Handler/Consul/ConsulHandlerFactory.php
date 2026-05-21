<?php

namespace Oka\ServiceDiscoveryBundle\Catalog\Handler\Consul;

use Consul\Client;
use Consul\Services\Catalog;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerFactoryInterface;
use Oka\ServiceDiscoveryBundle\Catalog\Handler\CatalogHandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Cedrick Oka Baidai <baidai.cedric@veone.net>
 */
class ConsulHandlerFactory implements CatalogHandlerFactoryInterface
{
    private $logger;

    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    public function supports(string $dsn, array $options): bool
    {
        return 0 === strpos($dsn, 'consul://') || 0 === strpos($dsn, 'consul-tls://');
    }

    /**
     * Creates a handler based on the DSN and options.
     *
     * Available options:
     *
     *   * Guzzle client all options availables
     */
    public function createHandler(string $dsn, array $options): CatalogHandlerInterface
    {
        if (false === class_exists('Consul\Services\Catalog')) {
            throw new \LogicException('For use consul catalog you have to install the "friendsofphp/consul-php-sdk:^3.0 || ^4.0 || ^5.0" bundle.');
        }

        // consul(-tls)?://... => http(s)?://... or else the URL will be invalid
        $dsn = preg_replace('#^consul(-tl(s))?:\/\/(.+)#i', 'http$2://$3', $dsn);

        if (false === parse_url($dsn)) {
            throw new \InvalidArgumentException(sprintf('The given Consul Catalog DSN "%s" is invalid.', $dsn));
        }

        return new ConsulHandler(new Catalog(new Client(array_merge($options, ['base_uri' => $dsn]), $this->logger)));
    }
}
