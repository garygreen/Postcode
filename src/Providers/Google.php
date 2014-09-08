<?php namespace Greeneh\Postcode\Providers;

use Greeneh\Postcode\AbstractProvider;
use Greeneh\Postcode\ProviderInterface;

class Google extends AbstractProvider implements ProviderInterface
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
			$source = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?region=gb&address=' . $postcode . '.json'));
		}
		catch (\Exception $e)
		{
			$this->throwServiceUnavailable();
		}

		if (!empty($source->results))
		{
			// Use the first result
			$result         = $source->results[0];

			// Default values
			$town           = null;
			$city           = null;
			$county         = null;
			$resultPostcode = null;

			// Determine the town, city, county and result postcode
			foreach ($result->address_components as $addressComponent)
			{
				$types = $addressComponent->types;
				$longname = $addressComponent->long_name;
				if (in_array('sublocality', $types))
				{
					$town = $longname;
				}
				elseif (in_array('locality', $types))
				{
					$city = $longname;
				}
				elseif (in_array('administrative_area_level_2', $types))
				{
					$county = $longname;
				}
				elseif (in_array('postal_code', $types))
				{
					$resultPostcode = $longname;
				}
			}

			// Build array of attributes for the address model
			$attributes = array(
				'latitude'  => $result->geometry->location->lat,
				'longitude' => $result->geometry->location->lng,
				'town'      => $town,
				'city'      => $city,
				'county'    => $county,
				'postcode'  => $resultPostcode,
			);

			return $this->newAddress($source, $attributes);
		}

		return null;
	}
}