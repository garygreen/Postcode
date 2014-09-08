<?php namespace Greeneh\Postcode;

interface ProviderInterface
{
	public function search($postcode);
	public function setApiKey($apiKey);
}