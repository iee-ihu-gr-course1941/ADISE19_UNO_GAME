<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">


    <script>
        $(document).ready(function () {
            $("#opponents").load("loadOpponents.php", {

            })
        })

    </script>




</head>
<body>
<div class="header">
    <h2>UNO</h2>
</div>
<div class="content">

    <div id="opponents">


    </div>




</div>

</body>
</html>