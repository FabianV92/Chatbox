<?php
?>
<html>
<head>
    <title>Recovery of the password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Confirmation of the new password</h1>
    <hr>
</header>
<div class="home"><a href="main.php">Home</a></div>
<form actin method="post" name="form">
    <table>
        <tr>
            <td><label>New Password</label></td>
            <td><input type="text" name="pass1"></td>
        </tr>
        <tr>
            <td><label>Retype the Password</label></td>
            <td><input type="text" name="pass2"></td>
        </tr>
        <tr>
            <td><input type="submit" value="confirm" name="confirmPw" class="confirmPw"></td>
        </tr>
    </table>
</form>
</body>
<?php
error_reporting(0);
include 'config.php';
global $myConn;

$pw1 = $_POST['pass1'];
$pw2 = $_POST['pass2'];

session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php"); // redirects to all records page
    exit;
}

if (isset($_POST['confirmPw'])) {
// If one of the fields are empty user will get a message below the submit
    if (empty($pw1) && empty($pw2)) {
        echo '<span style="color:#e30f0f; display: flex; justify-content: center; font-size:25px;">
        Empty fields, please fill the fields and try again.</span><br>';
    }

// Pass one and pass two are not equal to each other
    if ($pw1 != $pw2) {
        echo '<span style="color:#e30f0f; display: flex; justify-content: center; font-size:25px;">
        The two passwords dont match each other! Please try again. </span><br>';
    }

// If everything is alright then...
    session_start();
    if ($pw1 == $pw2 && !empty($pw1) && !empty($pw2) && $_SESSION['user']) {

        // Generate a new salt
        $salt = substr(base64_encode(openssl_random_pseudo_bytes(17)), 0, 22);
        $salt = str_replace("+", ".", $salt);

        // Generate hash
        $param = '$' . implode('$', array(
                "2y", //select the most secure version of blowfish (>=PHP 5.3.7)
                str_pad(11, 2, "0", STR_PAD_LEFT), //add the cost in two digits
                $salt //add the salt
            ));

        $hash[] = crypt($pw1, $param);
        $hastStr = "";
        $hastStr = $hastStr . implode($hash);

        echo $hastStr;

        $userSess = $_SESSION['user'];

        $sql = "UPDATE users SET hash='$hastStr', salt='$salt' WHERE user='$userSess'";

        if (mysqli_query($myConn, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($myConn);
        }

        session_destroy();
        mysqli_close($myConn);

        header("location:login.php"); // redirects to all records page
        exit;
    }
}


?>
</html>
