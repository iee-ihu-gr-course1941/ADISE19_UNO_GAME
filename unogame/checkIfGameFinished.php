<?php

include('../server.php');
include './globalFunctions.php';

$currentGameName = $_SESSION['gamename'];
$gameFinihsederror = "game_has_finished";

$gameFinihsed = checkIfGameHasFinished($currentGameName);
if ($gameFinihsed == true) {
    echo $gameFinihsederror;
}
?>