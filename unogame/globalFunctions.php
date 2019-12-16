<?php

include('../server.php');

function checkIfPlayerWillGetExtraCards($nextPlayerID, $cardThatJustPlayed) {
    global $db;
    $sql_to_get_card_details = "SELECT value from cards where cardid = '$cardThatJustPlayed'";
    $sql_result_to_get_card_details = mysqli_query($db, $sql_to_get_card_details);
    $firstrow_sql_result_to_get_card_details = mysqli_fetch_assoc($sql_result_to_get_card_details);
    $cardThatJustPlayedValue = $firstrow_sql_result_to_get_card_details['value'];

    // now we have the value of the card and we will check if he will get extra cards
    if (strcmp($cardThatJustPlayedValue,'plus2') == 0) {
        // We add 2 cards to the player
        addCardsToPlayer($nextPlayerID, 2);
        print("we add 2 cards to player, value = '$cardThatJustPlayedValue'");
    } else if (strcmp($cardThatJustPlayedValue,'baladerAddFour') == 0) {
        // We add 4 cards to the player
        addCardsToPlayer($nextPlayerID, 4);
        print("we add 4 cards to player, value = '$cardThatJustPlayedValue'");
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

?>