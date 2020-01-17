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

unset($_SESSION['gamename']);
unset($_SESSION['isAdmin']);
?>


<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Game Board</title>
    <link rel="stylesheet" type="text/css" href="../style.css">

    <script>

        $(document).ready(function () {
            $("#games_container").load("loadGames.php", {

            })
        })

    </script>


    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

<div>
    <?php  if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p> <a href="../logout.php" class='logoutButton'>logout</a> </p>
    <?php endif ?>
</div>

<div class="header">
    <h2>Games</h2>
</div>


<div class="content">





<div id="games_container">
    <!-- PHP scripts -->
    <!-- logged in user information -->

</div>



</div>
<?php
        echo "<form class='content' action='createGame.php' method='POST'>";
            echo "<input name='gamename' placeholder='Game Name' value=''>";
            echo "<button type='submit' class='btn'> Create game </button>";
        echo "</form>";
?>



</body>
</html>