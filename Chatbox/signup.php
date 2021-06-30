<?php
?>
<html>
<head>
    <title>Sign up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Welcome to the Sign up page</h1>
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
            <td><label>User name</label></td>
            <td><input type="text" name="user"></td>
        </tr>
        <tr>
            <td><label>Password</label></td>
            <td><input type="text" name="password"></td>
        </tr>
        <tr>
            <td class="tdSubmitSignup"><input type="submit" value="Register" class="submitSignup" name="submit"></td>
        </tr>
    </table>
</form>

<?php
include "config.php";
global $myConn;

error_reporting(0);

// If submit gets pressed
if (isset($_POST["submit"])) {

    // Fields
    $email = $_POST["email"];
    $user = $_POST["user"];
    $password = $_POST["password"];



    // Checking is username already exists
    $loopBool = true;
    $result = mysqli_query($myConn, "SELECT * FROM users WHERE user='$user'");
    $row = mysqli_fetch_array($result);

        for($i = 0; $i < count($row); $i++) {
            if ($row[$i] == $user) {
                echo '<span style="color:red; display: flex; justify-content: space-evenly; font-size:25px;">Username already exists!</span><br>';
                $loopBool = false;
            }
        }

// Displaying a user message if first name or last name input field is empty
    if (empty($email && $password && $user)) {
        echo '<span style="color:red; display: flex; justify-content: space-evenly; font-size:25px;">Empty fields!</span><br>';
    }

// Displaying a user message if invalid email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<span style="color:red; display: flex; justify-content: space-evenly; font-size:25px;">Invalid email format!</span><br>';
    }

    global $sql;

    // The query starts herer
    if (!empty($email && $password && $user) && filter_var($email, FILTER_VALIDATE_EMAIL)&& ($loopBool == true)) {
        $salt = substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);
        $salt = str_replace("+",".",$salt);
        $param = '$'.implode('$',array(
                "2y", //select the most secure version of blowfish (>=PHP 5.3.7)
                str_pad(11,2,"0",STR_PAD_LEFT), //add the cost in two digits
                $salt //add the salt
            ));

        $hash[] = crypt($password,$param);
        $hastStr = "";
        $hastStr = $hastStr.implode($hash);

        $sql = "INSERT INTO users (email, hash, user, salt) 
        VALUES ('$email','$hastStr','$user','$salt')";


        mysqli_query($myConn, $sql);
        mysqli_close($myConn);
        echo '<span style="color:#80ea6e; display: flex; justify-content: center; font-size:25px;">
        Successful created ! Please login ---> : <a style="text-decoration: none; color: white" href="login.php"> HERE</a></span><br>';
    }

}

include "Config.php";

?>
</body>
</html>