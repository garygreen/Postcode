<?php namespace Greeneh\Postcode;

class Postcode
{
	/**
	 * Provider/api
	 * @var
	 */
	protected $provider;

	/**
	 * Register the dependencies
	 * @param ProviderInterface $provider
	 */
	public function __construct(ProviderInterface $provider)
	{
		$this->setProvider($provider);
	}

	/**
	 * Set the provider / api to use
	 * @param ProviderInterface $provider
	 */
	public function setProvider(ProviderInterface $provider)
	{
		$this->provider = $provider;
	}

	/**
	 * Get the provider
	 * @return ProviderInterface
	 */
	public function getProvider()
	{
		return $this->provider;
	}

	/**
	 * Search the given postcodes geolocation data
	 * If cannot connect or decode the given api's data, will throw ServiceUnavailableException
	 * @param  string $postcode 
	 * @return array|null         The geolocation data
	 */
	public function search($postcode)
	{
		return $this->provider->search($this->sanitizePostcode($postcode));
	}

	/**
	 * Gets the lat/lng for the given postcode
	 * @param  string $postcode 
	 * @return array|null         The array of latitude, longitude or null if could not be found.
	 */
	public function getCoordinates($postcode)
	{
		$address = $this->search($this->sanitizePostcode($postcode));
		
		if ($address instanceof Address)
		{
			return array(
				'latitude'  => $address->latitude,
				'longitude' => $address->longitude,
			);
		}

		return null;
	}

	/**
	 * Sanitizes the postcode, removing spaces
	 * @param  string $postcode 
	 * @return string
	 */
	public function sanitizePostcode($postcode)
	{
		return str_replace(' ', '', $postcode);
	}
}