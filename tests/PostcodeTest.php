<?php namespace Greeneh\Postcode\Tests;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Greeneh\Postcode\Postcode;

class PostcodeTest extends PHPUnit_Framework_TestCase {

	protected $postcode;
	protected $provider;

	public static function setUpBeforeClass()
	{
		//
	}

	public function setup()
	{
		$this->postcode = new Postcode(
			$this->provider = m::mock('Greeneh\Postcode\ProviderInterface')
		);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testSearchCallsProvider()
	{
		$this->provider->shouldReceive('search')->with('ub19hp')->once();
		$this->postcode->search('ub1 9hp');
	}

	public function testGetCoordinatesCallsProvider()
	{
		$this->provider->shouldReceive('search')->with('ub19hp')->once();
		$this->postcode->getCoordinates('ub1 9hp');
	}
}