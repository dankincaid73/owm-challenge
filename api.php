<?php
include 'owmrequest.php';

/**
* Open Weather Map owmAPI class to execute predefined requests to the
* OWM API
* @author Dan Kincaid <dankincaid73@gmail.com>
*/
class owmAPI extends owmRequest
{
	public $zip;
	/**
	* Retrieves weather data by ZIP code and (optional) country code.
	* @param string $zip
	* @param string $countryCode
	* @return array
	*/
	public function getWeatherByZipCode ($zip, $countryCode = null)
	{
		$this->fetchOwmRequest(['zip' => $zip . ($countryCode !== null ? ','
		. $countryCode : '')])->getResponseJSON();
	}
}
