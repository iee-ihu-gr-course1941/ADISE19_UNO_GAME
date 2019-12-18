<?php

include('../server.php');
include './globalFunctions.php';

$not_your_turnError = "not_your_turn";
$you_cant_play_this_cardError = "you_cant_play_this_card";

$cardPlayedID = $_POST["selectedCardIDPassed"];
$colorForBalader = $_POST["colorForBalader"]; // This variable might be null
$currentUserID = $_SESSION['userID'];
$currentGameName = $_SESSION['gamename'];

// First we check if user is playing from gametowhoplays table

$isUserPlaying = checkIfUserIsPlaying($currentUserID, $currentGameName);
if ($isUserPlaying == false) { // Here we check if it's users order to play
    echo $not_your_turnError;
} else {
    // Now that we know that this is the current user we check if the card that he is about to play can be played. ex. in "Green 4" you can't play "Blue 6"

    $is_this_vard_valid = getIfCardIsValid($cardPlayedID,$currentGameName);
    echo "is_this_vard_valid = '$is_this_vard_valid'!!!";
    if ($is_this_vard_valid == false) {
        echo $you_cant_play_this_cardError;
    } else {
        applyCardEffects($currentGameName, $cardPlayedID, $currentUserID, $colorForBalader); // applyCardEffects is the function that will apply all the lose order - plus 2 - balader - switch order effects
        echo "ok card! :-)";
    }


}





?>