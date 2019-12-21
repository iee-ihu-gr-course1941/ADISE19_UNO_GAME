<?php

include('../server.php');
include './globalFunctions.php';

$not_your_turnError = "not_your_turn";
$you_have_already_Picked_a_card = "you_have_already_Picked_a_card";

$currentUserID = $_SESSION['userID'];
$currentGameName = $_SESSION['gamename'];

$isUserPlaying = checkIfUserIsPlaying($currentUserID, $currentGameName);
if ($isUserPlaying == false) { // Here we check if it's users order to play
    echo $not_your_turnError;
} else {
    $hasPickedACard = getIfUserHasPickedACard($currentUserID, $currentGameName);
    if ($hasPickedACard == false) {
        addCardsToPlayer($currentUserID, 1);
        updateUserHasPickedACard($currentUserID, $currentGameName, true);
    } else {
        echo $you_have_already_Picked_a_card;
    }
}

?>