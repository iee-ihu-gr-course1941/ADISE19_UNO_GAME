<?php
include('../server.php');
$gameID = $_POST['gameID'];
$_SESSION['gameID'] = $gameID;
echo "joinedGame: ";
echo $gameID;

$adminUserName = $_SESSION['username'];
$sql = "SELECT id FROM users WHERE username='$adminUserName'";
$resultID = mysqli_query($db, $sql);
$firstrow = mysqli_fetch_assoc($resultID);
$userID = $firstrow['id'];

echo '<p>';
echo "userID: ";
echo $userID;

$sql = "INSERT INTO gametousersconnection (userid, gameid) VALUES ('$userID','$gameID')";
$resultID = mysqli_query($db, $sql);
header("location: ../unogame");

?>