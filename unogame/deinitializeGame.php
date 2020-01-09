<?php


include('../server.php');


$currentGameID = $_SESSION['gameID'];

$sql = "DELETE FROM gametousersconnection WHERE gameid = '$currentGameID'";
$result = mysqli_query($db, $sql);

$sql = "DELETE FROM gametoorder WHERE gameid = '$currentGameID'";
$result = mysqli_query($db, $sql);

$sql = "DELETE FROM gametowhoPlays WHERE gameid = '$currentGameID'";
$result = mysqli_query($db, $sql);

$sql = "DELETE FROM games WHERE gameid = '$currentGameID'";
$result = mysqli_query($db, $sql);

?>