<?php
namespace Oka\ServiceDiscoveryBundle\Catalog;


/**
 *
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 *
 */
class ServiceCollection implements \IteratorAggregate
{
	private $services;
	
	public function __construct(Service ...$services)
	{
		$this->set(...$services);
	}
	
	public function all() :array
	{
		return $this->services;
	}
	
	public function has(Service $service) :bool
	{
		return in_array($service, $this->services, true);
	}
	
	public function hasKey(int $index) :bool
	{
		return isset($this->services[$index]);
	}
	
	public function get(int $index) :?Service
	{
		return $this->services[$index] ?? null;
	}
	
	public function add(Service $service) :self
	{
		$this->services[] = $service;
		return $this;
	}
	
	public function set(Service ...$services) :self
	{
		$this->services = [];
		foreach ($services as $service) {
			$this->add($service);
		}
		return $this;
	}
	
	public function remove(int $index) :self
	{
		unset($this->services[$index]);
		return $this;
	}
	
	public function indexOf(Service $service) :?int
	{
		$index = array_search($service, $this->services, true);
		
		return false !== $index ? $index : null;
	}
	
	public function count() :int
	{
		return count($this->services);
	}
	
	public function first() :?Service
	{
		$service = reset($this->services);
		
		return $service ?: null;
	}
	
	public function last() :?Service
	{
		$service = end($this->services);
		
		return $service ?: null;
	}
	
	public function sort(callable $callback) :bool
	{
		return usort($this->services, $callback);
	}
	
	public function filter(callable $callback, int $flag = null) :self
	{
		$filtered = array_filter($this->services, $callback, $flag);
		
		return new self(...$filtered);
	}
	
	public function reduce(callable $callback, int $initial = null)
	{
		return array_reduce($this->services, $callback, $initial);
	}
	
	public function getIterator()
	{
		return new \ArrayIterator($this->services);
	}
}
