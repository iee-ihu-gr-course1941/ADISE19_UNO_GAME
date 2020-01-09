<?php
include('../server.php');
include './globalFunctions.php';

$currentGameName = $_SESSION['gamename'];
$currentPlayerUserName = $_SESSION['username'];

$sqlInsertWinner = "SELECT winnerID FROM gameToWinner where gameName = '$currentGameName'";
$sql_query_result = mysqli_query($db, $sqlInsertWinner);
$sql_query_result_first_row = mysqli_fetch_assoc($sql_query_result);
$winnerID = $sql_query_result_first_row['winnerID'];

$sql_select_userDetails = "SELECT * FROM users where id = '$winnerID'";
$sql_result_userDetails = mysqli_query($db, $sql_select_userDetails);
$sql_result_userDetails_firstRow = mysqli_fetch_assoc($sql_result_userDetails);
$username = $sql_result_userDetails_firstRow['username'];

echo "Congratulations to $username";




?>