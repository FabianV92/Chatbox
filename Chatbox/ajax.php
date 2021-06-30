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

header('Content-type:application/json'); // redirects to all records page
$sql = ("SELECT user FROM msgs");
$result = $myConn->query($sql);
var_dump(json_encode($result));
echo json_encode($result) ;

?>
