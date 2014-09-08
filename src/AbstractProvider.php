<?php namespace Greeneh\Postcode;

abstract class AbstractProvider {

	/**
	 * Api key
	 * @var string|null
	 */
	protected $apiKey = null;

	/**
	 * Construct the provider
	 * @param string|null $apiKey
	 */
	public function __construct($apiKey = null)
	{
		$this->setApiKey($apiKey);
	}
	
	/**
	 * Throws service unavailable exception
	 * @return void
	 */
	public function throwServiceUnavailable()
	{
		throw new ServiceUnavailableException;
	}

	/**
	 * Create instance of address model with source and attributes
	 * @param  mixed $source     
	 * @param  array  $attributes 
	 * @return Address
	 */
	public function newAddress($source, array $attributes = array())
	{
		$address = new Address($attributes);
		$address->source = $source;
		return $address;
	}

	/**
	 * Api Key
	 * @param void
	 */
	public function setApiKey($key)
	{
		$this->apiKey = $key;
	}

}