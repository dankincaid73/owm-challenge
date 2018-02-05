<?php
include 'owmrequest.php';

//OWM API
//@author Dan Kincaid <dankincaid73@gmail.com>
class owmAPI extends owmRequest
{
	public $zip;
	//Retrieves weather data by ZIP code and (optional) country code.
	public function getWeatherByZipCode ($zip, $countryCode = null)
	{
    $this->fetchOwmRequest(['zip' => $zip . ($countryCode !== null ? ','
    . $countryCode : '')])->getResponseJSON();
  }
}
