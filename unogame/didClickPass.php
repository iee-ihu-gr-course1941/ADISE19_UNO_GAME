<?php

include('../server.php');
include './globalFunctions.php';

$not_your_turnError = "not_your_turn";
$you_must_pickACard_first = "you_must_pickACard_first";

$currentUserID = $_SESSION['userID'];
$currentGameName = $_SESSION['gamename'];
$gameFinihsed = "game_has_finished";
$isUserPlaying = checkIfUserIsPlaying($currentUserID, $currentGameName);

$gameFinihsed = checkIfGameHasFinished($currentGameName);
if ($gameFinihsed == true) {
    echo $gameFinihsed;
} else {
    if ($isUserPlaying == false) { // Here we check if it's users order to play
        echo $not_your_turnError;
    } else {
        $hasPickedACard = getIfUserHasPickedACard($currentUserID, $currentGameName);
        if ($hasPickedACard == true) {
            // We just update the who plays
            $nextPlayerID = getNextPlayerID($currentGameName, $currentUserID);
            updateWhoPlays($currentGameName, $nextPlayerID);
            updateUserHasPickedACard($currentUserID, $currentGameName, false);
        } else {
            echo $you_must_pickACard_first;
        }
    }
}
?>