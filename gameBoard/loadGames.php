<?php
    include('../server.php');
    $sql = "SELECT * FROM games where started = false";
    $result = mysqli_query($db, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $gameName = $row['gamename'];
        echo "<form class='.content' action='joingame.php' method='POST'>";
        echo "<p>";
        echo "   Game ID: ";
        echo "<b>";
        echo $row['gameid'];
        echo "</b>";
        echo "  Name: ";
        echo "     ";
        echo "<form class='.noBorder' action='joingame.php' method='POST'>";
        echo "<input name='gameName' placeholder='Game Name' value=$gameName hidden=true>";
        echo "<button type='submit'> Join </button>";
        echo "</form>";
        echo "<p>";
        echo "<p>";
        echo "<p>";
        echo "</form>";
    }



?>