<?php namespace Greeneh\Postcode\Providers;

use Greeneh\Postcode\AbstractProvider;
use Greeneh\Postcode\ProviderInterface;

class UKPostcode extends AbstractProvider implements ProviderInterface
{
	/**
	 * Search the given postcodes geolocation data
	 * If cannot connect or decode the given api's data, will throw ServiceUnavailableException
	 * @param  string $postcode 
	 * @return Address|null         The address
	 */
	public function search($postcode)
	{
		try
		{
			$result = json_decode(file_get_contents('http://uk-postcodes.com/postcode/' . $postcode . '.json'));
		}
		catch (\Exception $e)
		{
			$this->throwSerivceUnavailable();
		}

		return $this->newAddress($result, array(
			'latitude'  => $result->geo->lat,
			'longitude' => $result->geo->lng,
			'town'      => $result->administrative->ward->title,
			'city'      => $result->administrative->council->title,
			'county'    => $result->administrative->county->title,
			'postcode'  => $result->postcode,
		));
	}
}