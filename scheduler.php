<?php
include 'config.php';
include 'api.php';
include 'database.php';
// Create new DB Object
$db = new DB;
// Create new owmAPI Object
$weather = new owmAPI;

$filename = 'weather.db';
// Make sure DB exists. If not, create it
if (!file_exists($filename)) {
    $db->createDatabase();
}

// Minutes between API Requests
$interval = $requestInterval;
// Set script execution time
set_time_limit($executionTime);

while (true)
{
  $now = time();

  echo 'Retrieving and Saving Weather Data.' . PHP_EOL;

  foreach ($locations as $location) {
    // Make API Request
    $weather->getWeatherByZipCode($location);
    // Convert JSON to array
    $weatherArray = json_decode($weather->responseJSON,true);

    // Define input variables
    $zip = $location;
    $conditions = $weatherArray['weather'][0]['main'];
    $pressure = $weatherArray['main']['pressure'];
    $temperature = $weatherArray['main']['temp'];
    // After testing I found this value to be a bit squirrely
    // Checking to see if it is returned by the API
    if (isset($weatherArray['wind']['deg'])) {
      $windDirection =  $weatherArray['wind']['deg'];
    } else {
      $windDirection = 0;
    }
    $windSpeed = $weatherArray['wind']['speed'];
    $humidity = $weatherArray['main']['humidity'];
    $timestamp = $now;

    // Add record to database
    $db->addWeatherRecord ($zip, $conditions, $pressure, $temperature,
    $windDirection, $windSpeed, $humidity, $timestamp);
  }

  // Time to wait between API requests
  sleep($interval*60-(time()-$now));
}
?>
