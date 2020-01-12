<?php

include('../server.php');
include './globalFunctions.php';


$currentUserID = $_SESSION['userID'];
$currentGameName = $_SESSION['gamename'];

$isUserPlaying = checkIfUserIsPlaying($currentUserID, $currentGameName);


if ($isUserPlaying == false) { // Here we check if it's users order to play
    echo "";
} else {
    echo "It's your turn!";
}

?>