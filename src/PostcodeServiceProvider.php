<?php namespace Greeneh\Postcode;

use Config;
use Illuminate\Support\ServiceProvider;

class PostcodeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('greeneh/postcode');
	}

	/**
	* Register the service provider.
	*
	* @return void
	*/
	public function register()
	{
		// Register the package configuration.
		$this->app['config']->package('greeneh/postcode', realpath(__DIR__ . '/../config'));

		$this->app['postcode'] = $this->app->share(function($app)
		{
			$postcodeConfig = $app['config']->get('postcode::config');
			$providerClass  = $postcodeConfig['provider'];
			$provider       = new $providerClass($postcodeConfig['api_key']);
			return new Postcode($provider);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}