<?php

include('../server.php');
include('../Model/Card.php');

function checkIfPlayerWillGetExtraCards($nextPlayerID, $cardThatJustPlayed) {
    echo "checkIfPlayerWillGetExtraCards! :-)";
    global $db;
    $sql_to_get_card_details = "SELECT value from cards where cardid = '$cardThatJustPlayed'";
    $sql_result_to_get_card_details = mysqli_query($db, $sql_to_get_card_details);
    $firstrow_sql_result_to_get_card_details = mysqli_fetch_assoc($sql_result_to_get_card_details);
    $cardThatJustPlayedValue = $firstrow_sql_result_to_get_card_details['value'];

    // now we have the value of the card and we will check if he will get extra cards
    echo "cardThatJustPlayedValue: '$cardThatJustPlayedValue'";
    if (strcmp($cardThatJustPlayedValue,'plus2') == 0) {
        // We add 2 cards to the player
        addCardsToPlayer($nextPlayerID, 2);
        echo "we add 2 cards to player, value = '$cardThatJustPlayedValue'";
    } else if (strcmp($cardThatJustPlayedValue,'baladerAddFour') == 0) {
        // We add 4 cards to the player
        addCardsToPlayer($nextPlayerID, 4);
        echo "we add 4 cards to player, value = '$cardThatJustPlayedValue'";
    }
}

function addCardsToPlayer($playerID, $numberOfCards) {
    global $db;
    $countForLoop = (int)$numberOfCards;
    $gameName = $_SESSION['gamename'];

    // Now we get all the availableCards
    $available_cards = [];
    /* $_cardIds_cashed  is the array with the ids of the cards that will be used to suffle and get the players cards and the first card */
    $sql_get_all_available_cards = "SELECT availableCardId FROM game_to_not_played_cards where gamename = '$gameName'";
    $sql_get_all_available_cards_result = mysqli_query($db, $sql_get_all_available_cards);
    while ($row = mysqli_fetch_assoc($sql_get_all_available_cards_result)) {

        $availableCardId = $row['availableCardId'];
        echo "<h1> availableCardId $availableCardId </h1>";
        array_push($available_cards,$availableCardId);
    }
    // Now in $available_cards we have all availabel cards
    // TODO Check here if we have to reload the available cards if count < $numberOfCards
    // we suffle the array

    shuffle($available_cards);
    echo "<h1> countForLoop = $countForLoop </h1>";
    for ($i = 0; $i<$countForLoop; $i++) {
        $id_of_card_to_give_to_player = array_shift($available_cards);
        $sql_give_card_to_player = "INSERT INTO useridcardassotiation (userid, cardid) VALUES ('$playerID', '$id_of_card_to_give_to_player')";
        if ($db->query($sql_give_card_to_player) === TRUE) {
               echo "Test 123Insert ('$id_of_card_to_give_to_player', '$playerID') Succeed<p>";
        } else {
               echo "Error on id_of_card_to_give_to_player creating table: " . $db->error;
        }
        deleteFromGameToNotPlayedCards($gameName, $id_of_card_to_give_to_player);
    }
}


function deleteFromGameToNotPlayedCards($_currentGameName,$_id_of_card_to_give_to_player) {
        global $db;
        echo("deleteFromGameToNotPlayedCards: $_currentGameName - $_id_of_card_to_give_to_player");
        $removeFrom_playedCards_sql = "DELETE FROM game_to_not_played_cards WHERE gamename = '$_currentGameName' AND availableCardId = '$_id_of_card_to_give_to_player'";
        $random = mysqli_query($db, $removeFrom_playedCards_sql);
        if ($db->query($removeFrom_playedCards_sql) === TRUE) {
                echo "Succeed DELETE FROM game_to_not_played_cards ('$_currentGameName', '$_id_of_card_to_give_to_player') Succeed<p>";
        } else {
                echo "Error on game_to_not_played_cards creating table: " . $db->error;
        }
}

function checkIfUserIsPlaying($userID, $gameName): Bool {
    global $db;
    $sql_to_get_Now_Playing_UserID = "SELECT userid from gametowhoplays where gamename = '$gameName'";
    $sql_result_to_get_Now_Playing_UserID = mysqli_query($db, $sql_to_get_Now_Playing_UserID);
    $firstrow_sql_result_to_Now_Playing_UserID = mysqli_fetch_assoc($sql_result_to_get_Now_Playing_UserID);
    $currentPlayingUserID = $firstrow_sql_result_to_Now_Playing_UserID['userid'];
    if (strcmp($currentPlayingUserID,$userID) == 0) {
        return true;
    } else {
        return false;
    }
}


function getIfCardIsValid($cardPlayedID, $gamename): Bool {
    global $db;
    // First we need to get the details of the card that is about to be played
    // If the details of the card are not a balader card
    // then we need to get the details of the last played card
    $cardThatJustPlayed = getDetailsOfCard($cardPlayedID);
    if (($cardThatJustPlayed->value == "balader") or ($cardThatJustPlayed->value == "baladerAddFour")) {
        return true;
    } else {
        // Now we have to get the id of the last played card so that we can compare the cards
        $sql_query = "SELECT lastCardId from game_to_last_card where gamename = '$gamename'";
        $sql_query_result = mysqli_query($db, $sql_query);
        $sql_query_result_first_row = mysqli_fetch_assoc($sql_query_result);
        $lastCardId = $sql_query_result_first_row['lastCardId'];

        // Now we can get the card details from getDetailsOfCard function
        $lasPlayedCardDetails = getDetailsOfCard($lastCardId);

        echo "<p>lasPlayedCardDetails->value: '$lasPlayedCardDetails->value' <p>";
        echo "cardThatJustPlayed->value: '$cardThatJustPlayed->value'<p>";
        echo "lasPlayedCardDetails->color: '$lasPlayedCardDetails->color'<p>";
        echo "cardThatJustPlayed->color: '$cardThatJustPlayed->color'<p>";

        if (($lasPlayedCardDetails->value == $cardThatJustPlayed->value) or (($lasPlayedCardDetails->color == $cardThatJustPlayed->color))) {
            return true;
        } else if (($lasPlayedCardDetails->value == "balader") or ($lasPlayedCardDetails->value == "baladerAddFour")) {
            // WE NEED TO CHECK IF THE LAST CARD WAS BALADER!!!!
            $sql_query = "SELECT * from baladerSelectedColor where gamename = '$gamename'";
            $sql_query_result = mysqli_query($db, $sql_query);
            $sql_query_result_first_row = mysqli_fetch_assoc($sql_query_result);
            $color = $sql_query_result_first_row['color'];
            if ($cardThatJustPlayed->color == $color) {
                return true;
            } else {
                return false; // SOS Check before add more code!!!
            }
        } else {
            return false; // SOS Check before add more code!!!
        }

    }

}

function getDetailsOfCard($cardPlayedID): Card {
    global $db;
    $sql_query = "SELECT * from cards where cardid = '$cardPlayedID'";
    $sql_query_result = mysqli_query($db, $sql_query);
    $sql_query_result_first_row = mysqli_fetch_assoc($sql_query_result);
    $color = $sql_query_result_first_row['color'];
    $value = $sql_query_result_first_row['value'];
    $cardToReturn = new Card();
    $cardToReturn->id = $cardPlayedID;
    $cardToReturn->value = $value;
    $cardToReturn->color = $color;
    return $cardToReturn;
}

function updateBaladerSelectedColor($currentGameName, $color) {
    global $db;
    $sql_query = "UPDATE baladerselectedcolor set color = '$color' WHERE gamename = '$currentGameName'";
    if ($db->query($sql_query) === TRUE) {
        echo "UPDATE baladerselectedcolor succeed new color: '$color'";
    } else {
        echo "UPDATE baladerselectedcolor failed ". $db->error;
    }
}

function applyCardEffects($currentGameName, $cardID, $currentPlayerID, $colorForBalader) {
    global $db;
    $sql_give_card_to_player = "UPDATE game_to_last_card SET lastCardId = '$cardID' where gamename = '$currentGameName'";
    if ($db->query($sql_give_card_to_player) === TRUE) {
           // echo "INSERT INTO game_to_last_card ('$id_of_card_to_give_to_player', '$_tmp_userid') Succeed<p>";
    } else {
           echo "Error on UPDATE game_to_last_card ('$cardID'". $db->error;
    }
    deleteFromGameToNotPlayedCards($currentGameName,$cardID);

    $card = getDetailsOfCard($cardID);
    if (($card->color == "balader") or ($card->color == "baladerAddFour")){
        updateBaladerSelectedColor($currentGameName, $colorForBalader);
    } else if ($card->value == "loseOrder") {
       // Call function for loose order
    } else if ($card->value == "switchOrder") {
       // Call function for switch order
    }
    $nextPlayerID = getNextPlayerID($currentGameName, $currentPlayerID);
    // Now we check if next player needs to get extra cards!
    if (($card->color == "plus2") or ($card->color == "baladerAddFour")){
        checkIfPlayerWillGetExtraCards($nextPlayerID, $cardID);
    }
    updateWhoPlays($currentGameName, $nextPlayerID);
}

function updateWhoPlays($currentGameName, $newPlayerID) {
    global $db;
    $sql_query = "UPDATE gametowhoplays set userid = '$newPlayerID' WHERE gamename = '$currentGameName'";
    if ($db->query($sql_query) === TRUE) {
        echo "UPDATE gametowhoplays succeed new userid Players: '$newPlayerID'";
    } else {
            console.log("UPDATE gametowhoplays new userid failed  ". $db->error);
    }
}


function getNextPlayerID($currentGameName, $currentPlayerID): Int {
    global $db;
    $currentPlayerOrder = getCurrentPlayersOrder($currentGameName, $currentPlayerID); // we get the current players position from player id
    $currentPlayerOrderIncriesedOne = $currentPlayerOrder + 1; // we add one to the position and we get the id of the player that has position (players position + 1)
    $nextPlayerID = -1;

    $sql_query = "SELECT userid from gametoorder where (gameName = '$currentGameName') AND (playerorder = '$currentPlayerOrderIncriesedOne')";
    $sql_query_result = mysqli_query($db, $sql_query);
    $numberOfResults = mysqli_num_rows($sql_query_result); // We get the result of that query and if we have a result then the user wasn't the last one in the queue
    if ($numberOfResults > 0) {
        $sql_query_result_first_row = mysqli_fetch_assoc($sql_query_result);
        $nextPlayerID = $sql_query_result_first_row['userid'];
        if ($nextPlayerID > 0) {
            return $nextPlayerID;
        } else {
            $nextPlayerID = getFirstPlayersID($currentGameName);
        }

    } else { // If we had no result that means that the player that just played was the last one
        $nextPlayerID = getFirstPlayersID($currentGameName);
    }
    return $nextPlayerID;

}

function getFirstPlayersID($currentGameName): Int {
    global $db;
    $sql_query = "SELECT userid from gametoorder where playerorder = '1'";
    $sql_query_result = mysqli_query($db, $sql_query);
    $sql_query_result_first_row = mysqli_fetch_assoc($sql_query_result);
    $firstPlayerUserID = $sql_query_result_first_row['userid']; //Now we have the order of the current player
    return $firstPlayerUserID;
}

function getCurrentPlayersOrder($currentGameName, $currentPlayerID): Int {
    global $db;
    $sql_query = "SELECT playerorder from gametoorder where gameName = '$currentGameName' AND userid = '$currentPlayerID'";
    $sql_query_result = mysqli_query($db, $sql_query);
    $sql_query_result_first_row = mysqli_fetch_assoc($sql_query_result);
    $curret_playerorder = $sql_query_result_first_row['playerorder']; //Now we have the order of the current player
    return $curret_playerorder;

}
























?>