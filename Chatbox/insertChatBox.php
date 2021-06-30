<?php
include "config.php";
global $myConn;

session_start();
if ($_SESSION['user']) {
    $userTxt = $_POST['msg'];
    $tmpUser = $_SESSION['user'];
    $sql = mysqli_query($myConn, "INSERT INTO msgs (msg, user) VALUES ('$userTxt','$tmpUser')");
}
?>