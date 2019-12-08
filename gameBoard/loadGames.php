<?php
    include('../server.php');
    $sql = "SELECT * FROM games";
    $result = mysqli_query($db, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<form class='.content' action='joingame.php' method='POST'>";
        echo "<p>";
        echo "   Game ID: ";
        echo "<b>";
        echo $row['gameid'];
        echo "</b>";
        echo "  Name: ";
        $gameID = $row['gameid'];
        echo $row['gamename'];
        echo "     ";
        echo "<form class='.noBorder' action='joingame.php' method='POST'>";
        echo "<input name='gameID' placeholder='Game Name' value=$gameID hidden=true>";
        echo "<button type='submit'> Join </button>";
        echo "</form>";
        echo "<p>";
        echo "<p>";
        echo "<p>";
        echo "</form>";
    }



?>