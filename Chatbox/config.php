<?php
$sql= "SELECT * FROM users";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chatbox";

// Create connection
$myConn = new mysqli($servername, $username, $password, $dbname);

// Checking connection
if ($myConn->connect_error) {
    die("Connection failed: " . $myConn->connect_error);
}
$result = $myConn->query($sql);
?>