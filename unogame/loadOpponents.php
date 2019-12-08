<?php
include('../server.php');

$currentGameID = $_SESSION['gameID'];
$sql = "SELECT * FROM gametoorder where userid = '$currentGameID'";
$result = mysqli_query($db, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div>";
    $userid = $row['userid'];
    echo $userid;
    echo "<br>";
    echo "</div>";
}



?>