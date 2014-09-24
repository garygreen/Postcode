<?php namespace Greeneh\Postcode;

class Address implements \JsonSerializable
{
	/**
	 * Fillable address fields
	 * @var array
	 */
	protected $fillable = array(
		'town',
		'city',
		'county',
		'latitude',
		'longitude',
		'source',
		'postcode',
	);

	/**
	 * Attributes
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * Construct the address with given attributes
	 * @param array $attributes
	 */
	public function __construct(array $attributes = array())
	{
		// Initiate all fillable fields with null values
		$this->fill(array_fill_keys($this->fillable, null));

		// Fill with the given attributes
		$this->fill($attributes);
	}

	/**
	 * Fill the address with attributes
	 * @param  array $attributes
	 * @return Address
	 */
	public function fill(array $attributes = array())
	{
		foreach ($attributes as $attribute => $value)
		{
			if (in_array($attribute, $this->fillable))
			{
				$this->attributes[$attribute] = $value;
			}
		}

		return $this;
	}

	/**
	 * Determine if a property isset
	 * @param  string  $prop 
	 * @return boolean       
	 */
	public function __isset($prop)
	{
		return isset($this->attributes[$pro]);
	}

	/**
	 * Get attribute
	 * @param  string $prop 
	 * @return mixed
	 */
	public function __get($prop)
	{
		if (isset($this->attributes[$prop]))
		{
			return $this->attributes[$prop];
		}
	}

	/**
	 * Set attribute
	 * @param string $prop 
	 * @param mixed $value
	 */
	public function __set($prop, $value)
	{
		$this->attributes[$prop] = $value;
	}

	/**
	 * Serialize json array
	 * @return array
	 */
	public function jsonSerialize()
	{
		return $this->toArray();
	}

	/**
	 * Convert address to array
	 * @return array
	 */
	public function toArray()
	{
		return $this->attributes;
	}

	/**
	 * Convert the model instance to JSON.
	 * @param  int  $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return json_encode($this->toArray(), $options);
	}

	/**
	 * Convert model to string
	 * @return string
	 */
	public function __toString()
	{
		return $this->toJson();
	}
}