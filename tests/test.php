<?php
require_once('database.php');
require_once('api.php');

class owmTest extends \PHPUnit_Framework_TestCase
{
  private $owmAPI = null;
  private $owmRequest = null;
  private $db = null;
  private $weatherArray = null;
  private $result = null;
  private $database = null;

  // Setup for Tests
  public function setUp()
  {
    $this->owmAPI = new owmAPI;
    $this->owmRequest = new owmRequest;
    $this->db = new DB;
    $this->weather = new owmAPI;
  }

  // Destroy created objects
  public function tearDown()
  {
    $this->owmAPI = null;
    $this->owmRequest = null;
    $this->db = null;
  }

  // Check that the database exists
  public function testDBExists()
  {
    $this->assertFileExists('weather.db');
  }

  // Checks that class owmAPI exists and contains all
  // required properties/methods
  public function testClassOwmAPI()
  {
    $this->assertTrue(class_exists('owmAPI'),
    'Class owmAPI not exist');
    $this->assertObjectHasAttribute('zip', $this->owmAPI);
    $this->assertTrue(method_exists($this->owmAPI, 'getWeatherByZipCode'),
    'Class does not have method getWeatherByZipCode');
  }

  // Checks that class owmRequest exists and contains all
  // required properties/methods
  public function testClassOwmRequest()
  {
    $this->assertTrue(class_exists('owmRequest'),
    'Class owmRequest does not exist');
    $this->assertObjectHasAttribute('responseJSON', $this->owmRequest);
    $this->assertObjectHasAttribute('parameters', $this->owmRequest);
    $this->assertObjectHasAttribute('responseArray', $this->owmRequest);
    $this->assertTrue(method_exists($this->owmAPI, 'fetchOwmRequest'),
    'Class does not have method fetchOwmRequest');
    $this->assertTrue(method_exists($this->owmAPI, 'getResponseJSON'),
    'Class does not have method getResponseJSON');
  }

  // Checks that class DB exists and contains all required properties/methods
  public function testClassDB()
  {
    $this->assertTrue(class_exists('DB'),
    'Class DB does not exist');
    $this->assertObjectHasAttribute('zip', $this->db);
    $this->assertObjectHasAttribute('conditions', $this->db);
    $this->assertObjectHasAttribute('pressure', $this->db);
    $this->assertObjectHasAttribute('temperature', $this->db);
    $this->assertObjectHasAttribute('windDirection', $this->db);
    $this->assertObjectHasAttribute('windSpeed', $this->db);
    $this->assertObjectHasAttribute('humidity', $this->db);
    $this->assertObjectHasAttribute('timestamp', $this->db);
    $this->assertObjectHasAttribute('query', $this->db);
    $this->assertObjectHasAttribute('db', $this->db);
    $this->assertTrue(method_exists($this->db, 'createDatabase'),
    'Class does not have method createDatabase');
    $this->assertTrue(method_exists($this->db, 'addWeatherRecord'),
    'Class does not have method addWeatherRecord');
  }

  // Check API Request Results
  public function testRequestJson()
  {
    // Make API Request
    $this->owmAPI->getWeatherByZipCode('90210');
    // Convert JSON to array
    $this->weatherArray = json_decode($this->owmAPI->responseJSON,true);
    // Check that the result is an array
    $this->assertTrue(is_array($this->weatherArray),
    'Given value is not an array');
    // Check that required array keys exist
    $this->assertArrayHasKey('main', $this->weatherArray['weather'][0]);
    $this->assertArrayHasKey('speed', $this->weatherArray['wind']);
    $this->assertArrayHasKey('pressure', $this->weatherArray['main']);
    $this->assertArrayHasKey('temp', $this->weatherArray['main']);
    $this->assertArrayHasKey('humidity', $this->weatherArray['main']);
  }

  // Check DB Record Insertion
  public function testDatabaseInsert()
  {
    // Open Database
    $this->database = new SQLite3('weather.db')
    or die('Unable to open database');
    // Add Record
    $this->db->addWeatherRecord('00000', 'Test', 0, 0, 0, 0, 0, 00000000);
    // Check for test record
    $this->result = $this->database->exec('SELECT * FROM weather WHERE
    zip = "00000"') or die("Cannot run query");
    // Delete test record
    $this->database->exec('DELETE FROM weather WHERE zip = "00000";')
    or die("Cannot run query");
    // Check that record was in the DB
    $this->assertTrue($this->result, 1);
  }
}

?>
