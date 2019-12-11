<?php
include('../server.php');
$currentGameName = $_SESSION['gamename'];
echo "game with game id $currentGameName started";

$sql = "UPDATE games SET started = true where gamename = '$currentGameName'";
$resultID = mysqli_query($db, $sql);


/*
 * $sql = "INSERT INTO gametoorder (userid, gameid) VALUES ('$adminID','$gameID')";
        $resultID = mysqli_query($db, $sql);
 */


?>