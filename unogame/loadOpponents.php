<?php
include('../server.php');

$currentGameName = $_SESSION['gamename'];

echo "<h3>";
echo "gameName: ";
echo $currentGameName;
echo "</h3>";
$sql = "SELECT * FROM gametousersconnection where gameName = '$currentGameName'";


echo "<div class='parentsParent'>";
echo "<div class='aParent'>";

    $result = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_assoc($result)) {

        $opponentID = $row['userid'];
        $sql = "SELECT * FROM users where id = '$opponentID'";
        $newResult = mysqli_query($db, $sql);

        echo "<div class='card'>";
        echo "<img src='Assets/user.png' alt='Avatar' class = 'profileImage'>";
        echo "<div class='container'>";
        echo "<h4><b>";
        $firstrow = mysqli_fetch_assoc($newResult);
        $username = $firstrow['username'];
        echo "$username";
        echo "</b></h4>";
        echo "<div class='testContainer'>";
        echo "<div>";
        echo "<img src='Assets/uno.png' alt='Uno' class='unoImage'>";
        echo "</div>";
        echo "<div>";
        echo "<h1>7</h1>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }


echo "</div>";
echo "</div>";
?>