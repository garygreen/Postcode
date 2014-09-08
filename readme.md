# Postcode Search

Simple searching for postcodes to retrieve geographic information. Support for various API providers and a unified address/output format.

---

## Installation

### Laravel Specific

Add the following to your `config/app.php` 

1. `providers` array:

	'Greeneh\Postcode\PostcodeServiceProvider',

2. `aliases` array
	
	'Postcode' => 'Greeneh\Postcode\Facades\Postcode',

## Usage

### Retrieving geograhic information from a postcode:

```php
Postcode::search('E16 1FW')
```

#### Result from using the Google API Provider

```php
object(Greeneh\Postcode\Address)[282]
  protected 'fillable' => 
    array (size=6)
      0 => string 'town' (length=4)
      1 => string 'city' (length=4)
      2 => string 'county' (length=6)
      3 => string 'latitude' (length=8)
      4 => string 'longitude' (length=9)
      5 => string 'source' (length=6)
  protected 'attributes' => 
    array (size=6)
      'town' => null
      'city' => string 'London' (length=6)
      'county' => string 'Greater London' (length=14)
      'latitude' => float 51.5166391
      'longitude' => float 0.0210837
      'source' => 
        object(stdClass)[246]
          public 'results' => 
            array (size=1)
              0 => 
                object(stdClass)[250]
                  public 'address_components' => 
                    array (size=6)
                      0 => 
                        object(stdClass)[232]
                          public 'long_name' => string 'E16 1FW' (length=7)
                          public 'short_name' => string 'E16 1FW' (length=7)
                          public 'types' => 
```

### Get the lat/lng from a postcode

```php
Postcode::getCoordinates('E16 1FW')
```

#### Result

```php
array (size=2)
	'latitude' => float 51.6359841
	'longitude' => float 0.2919168
```