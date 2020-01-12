<?php
    include('../server.php');
    $sql = "SELECT * FROM games where started = false";
    $result = mysqli_query($db, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $gameName = $row['gamename'];
        echo "<form class='.content' action='joingame.php' method='POST'>";
        echo "   ID: ";
        echo "<b>";
        echo $row['gameid'];
        echo "</b>";
        echo "  Name: ";
        echo "<b>$gameName <b>    ";

        // get players count
        //gameid
        $sql_to_get_NumberOfPlayers = "SELECT count(*) as countPlayers from gametousersconnection where gameName = '$gameName'";
        $sql_result_NumberOfPlayers = mysqli_query($db, $sql_to_get_NumberOfPlayers);
        $firstrow_sql_result_NumberOfPlayers = mysqli_fetch_assoc($sql_result_NumberOfPlayers);
        $numberOfPlayers = $firstrow_sql_result_NumberOfPlayers['countPlayers'];

        echo "<b> Players: $numberOfPlayers   ";

        echo "<form class='.noBorder' action='joingame.php' method='POST'>";
        echo "<input name='gameName' placeholder='Game Name' value=$gameName hidden=true>";
        echo "<button type='submit' class='btn'> Join </button>";
        echo "</form>";
        echo "</form>";
    }



?>