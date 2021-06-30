

<html>
<head>
    <title>Main</title>
    <link rel="stylesheet" href="main.css">
    <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
</head>
<body>
<header>
    <h1>Welcome to the Chatbox !</h1>
</header>
<div class="menuBar ">
    <a class="signUp" href="signup.php">Sign up</a>
    <a class="login" href="login.php">Login</a>
    <form action method="post" name="form">
        <input type="submit" name="logout" value="Logout" class="logout hidden">
    </form>
</div>
<div class="chatBox-Container">
    <section class="chatBox">

    </section>
    <form action method="post">
        <table>
            <tr>
                <td><label>Your message</label></td>
                <td><input type="text" name="msg" class="msg"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submitChat" class="chatBoxSubmit"></td>
            </tr>
        </table>
    </form>
</div>
<div class="hidden"></div>
<script>
    // Using jquery get value checking the value. If the value is not empty ajax will be executed
    $(document).ready(function (){
        $(".chatBoxSubmit").click(function (){
            var msgTxt = $(".msg").val();
            if($.trim(msgTxt) !== '') {
                $.ajax({
                        url:"insertChatBox.php",
                        method:"POST",
                        data:{msg:msgTxt},
                        dataType:"text",
                        success:function (data){
                            $(".msg").val("")
                        }
                    }
                )};
        })
        setInterval(function () {
            $(".chatBox").load("fetchChatBox.php").fadeIn("slow");
        },100)
    });
</script>
<?php
// IF user is logged in ...
include "config.php";
global $myConn;
error_reporting(0);
session_start();
if (isset($_SESSION['user'])) {
    ?>
    <script type="text/javascript">document.querySelector(".signUp").style.display = 'none'
        document.querySelector(".login").style.display = 'none'
        document.querySelector(".logout").classList.remove("hidden");
        document.querySelector(".logout").style.color = "white";</script>
    <?php
}

// If user logs out
if (isset($_POST['logout'])) {
    session_start();
    $_SESSION . session_destroy();

    ?>
    <script type="text/javascript">document.querySelector(".signUp").style.display = 'block'
        document.querySelector(".login").style.display = 'block'
        document.querySelector(".logout").classList.add("hidden");</script>
    <?php


}
// It message box is empty or not logged in
$userTxt = $_POST['msg'];
// If not logged in
if (isset($_POST['submitChat']) && !$_SESSION['user']) {
    echo '<span style="color:#e30f0f; display: flex; justify-content: center; font-size:25px;">
        You have to be logged in to user the chat box !</span><br>';
}
// If logged in and empty fields
if (isset($_POST['submitChat']) && empty($userTxt) && $_SESSION['user']) {
    echo '<span style="color:#e30f0f; display: flex; justify-content: center; font-size:25px;">
        Empty field! Can not send an empty message! </span><br>';
}
?>
</body>
</html>
