<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: ../login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="gamecss.css">


    <script>
        $(document).ready(function () {
            $("#opponents").load("loadOpponents.php", {

            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $("#startButton").load("checkIfAdminStartButton.php", {

            })
        })

    </script>

    <script type='text/javascript'>
        function buttonStartDidClick() {
                document.getElementById('buttonStart').style.display='none';
                $.get('startGame.php'), function (data) {

                }
        }
    </script>
    <script>
        $(window).bind('beforeunload', function(){
            $.get('deinitializeGame.php', function(data) {

            });
        });

    </script>



</head>
<body>
<div class="header">
    <h2>UNO</h2>


    <div id="exit">
        <form>


        </form>

    </div>

    <div id="startButton">




    </div>

</div>
<div class="content">

    <div id="opponents">


    </div>




</div>

</body>
</html>