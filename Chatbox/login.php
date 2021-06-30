<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Welcome to the login page</h1>
    <hr>
</header>
<div class="home"><a href="main.php">Home</a></div>
<form action method="post" name="form">
    <table>
        <tr>
            <td><label>Email adress</label></td>
            <td><input type="text" name="email"></td>
        </tr>
        <tr>
            <td><label>Password</label></td>
            <td><input type="text" name="password"></td>
        </tr>
        <tr>
            <td class="tdSubmitLogin"><input type="submit" value="Submit" class="submitLogin" name="submit"></td>
        </tr>
    </table>
    <a href="forgotPass.php">forgot the password?</a>
</form>
</body>
<?php

// If submit gets pressed
if(isset($_POST["submit"])) {

error_reporting(0);
include  "config.php";
global $myConn;
global $GLOBALS;

    // Fields
    $email= $_POST["email"];
    $password = $_POST["password"];
    // Checking is email and password is correct

    // Query of the hashcode
    $sql = mysqli_query($myConn,"SELECT hash FROM users WHERE email='$email'");
    $row = mysqli_fetch_array($sql);


    // Query of the salt
    $saltQuery = mysqli_query($myConn,"SELECT salt FROM users WHERE email='$email'");
    $rowS = mysqli_fetch_array($saltQuery);


    if (empty($email)||empty($password)) {
        echo '<span style="color:#e30f0f; display: flex; justify-content: center; font-size:25px;">
        Empty fields, please fill the fields and try again.</span><br>';

    }else {
    echo '<span style="color:#e30f0f; display: flex; justify-content: center; font-size:25px;">
        Wrong Email or password, please try again. </span><br>';
    }


    // Checking is generating has with the salt and the password
    $param = '$'.implode('$',array(
            "2y", //select the most secure version of blowfish (>=PHP 5.3.7)
            str_pad(11,2,"0",STR_PAD_LEFT), //add the cost in two digits
            $rowS[0] //add the salt
        ));
    $hash[] = crypt($password,$param);
    $hastStr = "";
    $hastStr = $hastStr.implode($hash);
    $tmpHas = $row[0];


    // Checking if has from db and generated has are the same
    if ($tmpHas == $hastStr) {

        $sqlUser = mysqli_query($myConn,"SELECT user FROM users WHERE email='$email'");
        $users = mysqli_fetch_array($sqlUser);
        $user = $users[0];
        session_start();
        $_SESSION['user'] = $user;
        mysqli_close($myConn);
        header("location:main.php"); // redirects to all records page
        exit;
    }
    else {
        mysqli_close($myConn);
    }
}


?>
</html>
