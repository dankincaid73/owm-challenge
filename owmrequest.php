<?php

// API owmRequest class.
//@author Dan Kincaid <dankincaid73@gmail.com>
class owmRequest
{
  // These would usually be saved to a .env file but I wanted this
  // to be easy for you guys to just download and run

  // Open Weather Map Web Address
  const URL = 'http://api.openweathermap.org/data/2.5/weather';
  // Open Weather Map API Key
  const API_KEY = '4a8c2532441e2105ce0a33c515c5f910';
  // // Open Weather Map Unit Of Measurement - Fahrenheit: "imperial"
  const UNIT = "imperial";

  public $responseJSON = null;
  private $parameters = [];
  private $responseArray = [];


  //Constructor Sets APPID and Response Unit
	public function __construct ()
	{
    // Set APPID
    $this->parameters['appid'] = self::API_KEY;
    // Set the response unit
    $this->parameters['units'] = self::UNIT;
	}

  //API Fetch Method
	public function fetchOwmRequest (array $queryString = [])
	{
    // Concatenate URL, make request and return the response
		$this->responseJSON = file_get_contents(self::URL . '?' .
    http_build_query(($this->parameters + $queryString), null, '&'));

    // Convert JSON to Array
    $this->responseArray = json_decode($this->responseJSON, true);

    // Check for valid array
    if (!is_array($this->responseArray))
		{
			throw new \ErrorException('The Open Weather Map API response
      returned no valid JSON: ' . $this->responseJSON);
		}

    // Check for errors
		if (isset($this->responseArray['response']['error']))
		{
			throw new \ErrorException('The Open Weather Map API
      responded with errors: ' .
      var_export($this->responseArray['response']['error'], true));
		}

		return $this;
	}


  //Method for returning the JSON Response
	public function getResponseJSON ()
	{
		return $this->responseJSON;
	}
}
