<?php
$servername = 'shittalk.cinwj67fm5hu.us-east-1.rds.amazonaws.com';
$username = "shittalk";
$password = "shittalk";
$dbname = "shittalk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "WHat up dudes, it works";
}
