<?php
include('../server.php');
$gameName = $_POST['gameName'];
$_SESSION['gamename'] = $gameName;
echo "joinedGame: ";
echo $gameName;

$adminUserName = $_SESSION['username'];
$sql = "SELECT id FROM users WHERE username='$adminUserName'";
$resultID = mysqli_query($db, $sql);
$firstrow = mysqli_fetch_assoc($resultID);
$userID = $firstrow['id'];
$_SESSION['userID'] = $userID;
$_SESSION['isAdmin'] = false;

echo '<p>';
echo "userID: ";
echo $userID;

$sql = "INSERT INTO gametousersconnection (userid, gameName) VALUES ('$userID','$gameName')";
$resultID = mysqli_query($db, $sql);

header("location: ../unogame");

?>