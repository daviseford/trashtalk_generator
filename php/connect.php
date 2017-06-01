<?php
$hostname = 'shittalk.cinwj67fm5hu.us-east-1.rds.amazonaws.com';
$username = "shittalk";
$password = "shittalk";
$dbname = "shittalk";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
echo "Connected to MySQL using username - $username, password - $password, host - $hostname<br>";
$selected = mysql_select_db("$dbname",$dbhandle)   or die("Unable to connect to MySQL DB - check the database name and try again.");

$servername = 'shittalk.cinwj67fm5hu.us-east-1.rds.amazonaws.com';
$username = "shittalk";
$password = "shittalk";
$dbname = "shittalk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "WHat up dudes";
}

?>