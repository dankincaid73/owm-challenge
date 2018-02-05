<?php
/**
* Open Weather Map API class to add records to the database
* @author Dan Kincaid <dankincaid73@gmail.com>
*/
class DB {
  public $zip;
  public $conditions;
  public $pressure;
  public $temperature;
  public $windDirection;
  public $windSpeed;
  public $humidity;
  public $timestamp;
  private $db;
  private $query;

  public function createDatabase(){
    // Open a connection to the database
    $db = new SQLite3('weather.db') or die('Unable to open database');

    // Query string to create the Weather table
    $query = 'CREATE TABLE IF NOT EXISTS weather (
        id INTEGER PRIMARY KEY,
        zip TEXT NOT NULL,
        conditions TEXT NOT NULL,
        pressure INTEGER NOT NULL,
        temperature INTEGER NOT NULL,
        wind_direction INTEGER,
        wind_speed INTEGER NOT NULL,
        humidity INTEGER NOT NULL,
        timestamp INTEGER NOT NULL )';

    // Execute the query
    $db->exec($query) or die('Create db failed');
  }

  /**
  * Adds new weather records to the database
  * @param string $zip
  * @param string $conditions
  * @param integer $pressure
  * @param integer $temperature
  * @param integer $windDirection
  * @param integer $windSpeed
  * @param integer $humidity
  * @param integer $timestamp
  * @return string
  */
  public function addWeatherRecord($zip, $conditions, $pressure, $temperature,
  $windDirection, $windSpeed, $humidity, $timestamp) {
    // Open DB
    $db = new SQLite3('weather.db') or die('Unable to open database');
    // Create query string
    $query = 'INSERT INTO weather ( zip, conditions, pressure, temperature,
    wind_direction, wind_speed, humidity, timestamp)
    VALUES ( "' . $zip . '", "' . $conditions . '", ' . $pressure . ',
    ' . $temperature . ', ' . $windDirection . ', ' . $windSpeed . ',
    ' .$humidity . ', ' .$timestamp . ')';
    // Execute query
    $db->exec($query) or die("Unable to add weather");

    return "Record added to the database.";
  }
}
