<strong>The Hourly Weather Tracker: An API Coding Exercise</strong>

<p>The purpose of this exercise is to gain a better understanding of how you approach a more complicated problem. The exercise should take you 4 to 5 hours to complete. Documenting your design decision is a plus.

Exercise Instructions <br>
<br>o    Create an application that will track current weather measurements for a given set of zip codes
<br>o    Store the following data at a minimum:
<br>o    Zip code,
<br>o    General weather conditions (e.g. sunny, rainy, etc),
<br>o    Atmospheric pressure,
<br>o    Temperature (in Fahrenheit),
<br>o    Winds (direction and speed),
<br>o    Humidity,
<br>o    Timestamp (in UTC)
<br>o    There is no output requirement for this application, it is data retrieval and storage only
<br>o    The application should be able to recover from any errors encountered
<br>o    The application should be developed using a TDD approach. 100% code coverage is not required
<br>o     The set of zip codes and their respective retrieval frequency should be contained in configuration file
</p>


<p>
Generally I would create something like this in an MVC framework such as Laravel but my goal here was to create an example with no setup so you can just download it and run it.

<strong>config.php</strong> - holds a location array, the request interval time between hitting the OWM API, and the execution time of how long the script should run.<br><br>
<strong>api.php</strong> - handles creating the request string and then passing it to the request object.<br><br>
<strong>owmrequest.php</strong> - makes the request to the OWM API and returns a JSON object.<br><br>
<strong>database.php</strong> - handles the creation of a sqlite3 database, the creation of the weather table and inserting weather data to the DB. I chose sqlite3 as my storage mechanism because it's file based and requires no setup on your part.<br><br>
<strong>index.php</strong> - is a quick one off that hits the API and stores the results to the DB as well as displaying the data retrieved.<br><br>
<strong>scheduler.php</strong> - generally I would use a cron job to run the script every hour. But that would have required you to set up the job on your server. Instead I simulated a cron using sleep(). The request interval is set in config.php.<br><br>
<strong>tests/test.php</strong> - contains a test suite for the application.  I set up tests to ensure the database exists, that all the required classes exist along with their properties and methods, that the API call is returning data and contains all the needed array keys, and that the database insert is working properly. I'm fairly new to TDD but I learn quickly. <br><br> 
</p>
