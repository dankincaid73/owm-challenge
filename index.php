<?php
include 'config.php';
include 'api.php';
include 'database.php';

$db = new DB;
$weather = new owmAPI;
$filename = 'weather.db';
// Make sure DB exists. If not, create it
if (!file_exists($filename)) {
    $db->createDatabase();
}

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
  $timestamp = time();

  // Output Variables for testing
  echo  'Zip: ' . $zip . '<br>';
  echo  'Conditions: ' . $conditions . '<br>';
  echo  'Pressure: ' . $pressure . '<br>';
  echo  'Temperature: ' . $temperature . '<br>';
  echo  'Wind Direction: ' . $windDirection . '<br>';
  echo  'Wind Speed: ' . $windSpeed . '<br>';
  echo  'Humidity: ' . $humidity . '<br>';
  echo  'Timestamp: ' . $timestamp . '<br><br>';

  // Add record to database
  $db->addWeatherRecord ($zip, $conditions, $pressure, $temperature,
  $windDirection, $windSpeed, $humidity, $timestamp);
}
