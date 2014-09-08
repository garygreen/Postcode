<?php namespace Greeneh\Postcode\Providers;

use Exception;
use Greeneh\Postcode\AbstractProvider;
use Greeneh\Postcode\ProviderInterface;

class MapQuest extends AbstractProvider implements ProviderInterface
{
	/**
	 * Search the given postcodes geolocation data
	 * If cannot connect or decode the given api's data, will throw ServiceUnavailableException
	 * @param  string $postcode 
	 * @return Address|null         The address
	 */
	public function search($postcode)
	{
		if ($this->apiKey === null)
		{
			throw new Exception('MapQuest Provider requires an API Key to be set.');
		}

		try
		{
			$params = http_build_query(array(
				'key'        => $this->apiKey,
				'country'    => 'GB',
				'postalCode' => $postcode,
				'thumbMaps'  => 'false',
				'maxResults' => 1
			));
			$source = json_decode(file_get_contents('http://www.mapquestapi.com/geocoding/v1/address?' . $params));
		}
		catch (\Exception $e)
		{
			$this->throwServiceUnavailable();
		}

		if ($source->info->statuscode === 0 && !empty($source->results[0]->locations))
		{
			// Use the first result
			$result = $source->results[0];
			$location = $result->locations[0];

			// Only allow results for postal codes qualities.
			if ($location->geocodeQuality == 'ZIP')
			{
				// Build array of attributes for the address model
				$attributes = array(
					'latitude'  => $location->latLng->lat,
					'longitude' => $location->latLng->lng,
					'town'      => $location->adminArea6,
					'city'      => $location->adminArea5,
					'county'    => $location->adminArea4,
					'postcode'  => $result->providedLocation->postalCode,
				);

				return $this->newAddress($source, $attributes);
			}
		}

		return null;
	}
}