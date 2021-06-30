<?php
include "config.php";
global $myConn;

$sql = "SELECT user, time, msg FROM msgs WHERE  time >= CURRENT_DATE+ '00:00:00' ORDER BY time DESC";
$res =  mysqli_query($myConn,$sql);

if (mysqli_num_rows($res) > 0 ) {
    while ($row = mysqli_fetch_array($res)) {
        echo "<p>"."<span style='color: orange'>".$row['time'].' '."</span>"."<span style='color: #e30f0f'>" . $row['user'] . '</span>' . ': ' . $row['msg'] ."</p>". '<br>' ;
    }
}

?>