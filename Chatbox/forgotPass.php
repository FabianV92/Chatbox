<?php
?>

<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Recover</title>
</head>
<body>
<header>
    <h1>Recovery of the password</h1>
    <hr>
</header>
<div class="home"><a href="main.php">Home</a></div>
<form action method="post" name="form">
    <table>
        <tr>
            <td><label>Email address</label></td>
            <td><input type="text" name="email"></inp></in></td>
        </tr>
        <tr>
            <td><label>Username</label></td>
            <td><input type="text" name="user"></inp></in></td>
        </tr>
        <tr>
            <td><input type="submit" value="Reset" name="submit" class="submitReset"></td>
        </tr>
    </table>
</form>
<?php
include "config.php";
global $myConn;
error_reporting(0);
if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $user = $_POST['user'];
    $emailExist = False;
    $userExist = False;

    // If one of the fields are empty user will get a message below the submit
    if (empty($email) || empty($user)) {
        echo '<span style="color:#e30f0f; display: flex; justify-content: center; font-size:25px;">
        Empty fields, please fill the fields and try again.</span><br>';
    }

    // If not empty
    if (!empty($email) || !empty($user)) {
        // Getting data from DB
        $sqlEmail = mysqli_query($myConn,"SELECT email FROM users WHERE email='$email'");
        $rowEmail = mysqli_fetch_array($sqlEmail);



        $sqlUser = mysqli_query($myConn,"SELECT user FROM users WHERE user='$user'");
        $rowUser = mysqli_fetch_array($sqlUser);

        // Looping through email and check if exists
        for ($i = 0; $i < count($rowEmail); $i++) {
            echo "for loow email =  $rowEmail[$i]";
            if ($rowEmail[$i] == $email) {
                $emailExist = True;
            }
        }

        // Looping through user and check if exists
        for ($i = 0; $i < count($rowUser); $i++) {
            if ($rowUser[$i] == $user) {
                $userExist = True;
            }
        }

        if ($userExist  && $emailExist) {
            $sqlCheckUser = mysqli_query($myConn,"SELECT email FROM users WHERE user='$user'");
            $result = mysqli_fetch_array($sqlCheckUser);

            if ($email == $result[0]) {
            session_start();
            $_SESSION['user']= $user;
            header("location:confirmPass.php"); // redirects to all records page
            exit;
            }
        }
        else {
            $userExist = False;
            $emailExist = False;
            echo '<span style="color:#e30f0f; display: flex; justify-content: center; font-size:25px;">
            Wrong Email or Username please try again. </span><br>';

        }

    }
}
?>
</body>
</html>
