<?php
namespace Oka\ServiceDiscoveryBundle\Catalog;

/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
class Service
{
	private $scheme;
	private $host;
	private $port;
	private $weight;
	
	public function __construct(string $host, int $port = 80, string $scheme = 'http', int $weight = 1)
	{
		$this->host = $host;
		$this->port = $port;
		$this->scheme = $scheme;
		$this->weight = $weight;
	}
	
	public function getScheme() :string
	{
		return $this->scheme;
	}
	
	public function getHost() :string
	{
		return $this->host;
	}
	
	public function getPort() :int
	{
		return $this->port;
	}
	
	public function getWeight() :int
	{
		return $this->weight;
	}
	
	public function getUrl() :string
	{
		return $this->__toString();
	}
	
	public function __toString()
	{
		return sprintf('%s://%s:%s', $this->scheme, $this->host, $this->port);
	}
}
