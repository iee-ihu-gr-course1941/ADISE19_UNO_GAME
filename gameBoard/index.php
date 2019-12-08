<?php
	session_start();
?>


<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Game Board</title>
    <link rel="stylesheet" type="text/css" href="style.css">

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
        <p> <a href="../logout.php" style="color: red;">logout</a> </p>
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
            echo "<button type='submit'> Create game </button>";
        echo "</form>";
?>



</body>
</html>