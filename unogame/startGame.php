<?php
include('../server.php');
$currentGameName = $_SESSION['gamename'];
echo "game with game id $currentGameName started";

$sql = "UPDATE games SET started = true where gamename = '$currentGameName'";
$resultID = mysqli_query($db, $sql);

$sql_getAllPlayers = "SELECT * FROM gametousersconnection where gameName = '$currentGameName'";
$result_getAllPlayers = mysqli_query($db, $sql_getAllPlayers);


// ---------- Add the deck of cards to the game to not played table ------- //

$_cardIds_cashed = [];
/* $_cardIds_cashed  is the array with the ids of the cards that will be used to suffle and get the players cards and the first card */
$_getAllCardsFromCardsTableSql = "SELECT * FROM cards";
$_getAllCardsFromCardsTableSql_result = mysqli_query($db, $_getAllCardsFromCardsTableSql);
while ($row = mysqli_fetch_assoc($_getAllCardsFromCardsTableSql_result)) {
       $_card_id = $row['cardid'];
       array_push($_cardIds_cashed,$_card_id);
       $insert_into_game_to_not_played_cards_sql = "INSERT INTO game_to_not_played_cards (availableCardId,gamename) VALUES ('$_card_id', '$currentGameName')";
       if ($db->query($insert_into_game_to_not_played_cards_sql) === TRUE) {
               //echo "insert_into_game_to_not_played_cards_sql, '$_card_id','$currentGameName' Succeed)<p>";
           } else {
               echo "insert_into_game_to_not_played_cards_sql Failed  , '$_card_id','$currentGameName'<p>";
           }
}
shuffle($_cardIds_cashed); // Here the cards are being suffled
echo "Array cashed: [";
print_r($_cardIds_cashed);
echo "'] <p>";



// ---- Give order to players in the game -------------///

$_order_counter = 1;
while ($row = mysqli_fetch_assoc($result_getAllPlayers)) {
    $_tmp_userid = $row['userid'];
    $sql_insert_player_into_order = "INSERT INTO gametoorder (gameName, userid, playerorder) VALUES ('$currentGameName', '$_tmp_userid','$_order_counter')";

    if ($db->query($sql_insert_player_into_order) === TRUE) {
        //echo "Insert ('$currentGameName', '$_tmp_userid','$_order_counter')<p>";
    } else {
        echo "Error on sql_insert_player_into_order creating table: " . $db->error;
    }

    // for each player we get 7 cards as the uno rulles say

    for ($_i = 0; $_i<7; $_i++) {
        $id_of_card_to_give_to_player = array_shift($_cardIds_cashed);
        $sql_give_card_to_player = "INSERT INTO useridcardassotiation (userid, cardid) VALUES ('$_tmp_userid', '$id_of_card_to_give_to_player')";
        if ($db->query($sql_give_card_to_player) === TRUE) {
               // echo "Insert ('$id_of_card_to_give_to_player', '$_tmp_userid') Succeed<p>";
        } else {
               echo "Error on id_of_card_to_give_to_player creating table: " . $db->error;
        }

        deleteFromGameToNotPlayedCards($currentGameName, $id_of_card_to_give_to_player);

    }
    $_order_counter = $_order_counter + 1;
}

// After every player gets a card, set the card that opens the from the deck
$id_of_first_card_in_deck = array_shift($_cardIds_cashed);
$sql_give_card_to_player = "INSERT INTO game_to_last_card (gamename, lastCardId) VALUES ('$_tmp_userid', '$id_of_card_to_give_to_player')";
if ($db->query($sql_give_card_to_player) === TRUE) {
       // echo "INSERT INTO game_to_last_card ('$id_of_card_to_give_to_player', '$_tmp_userid') Succeed<p>";
} else {
       echo "Error on INSERT INTO game_to_last_card ('$id_of_card_to_give_to_player'". $db->error;
}
deleteFromGameToNotPlayedCards($currentGameName,$id_of_first_card_in_deck);


// Now we configure the value of the player that playes first
// Get all players that play in gametoorder table
$sql_get_players_of_game = "SELECT userid FROM gametoorder where playerorder = (SELECT MIN(playerorder) FROM gametoorder)"; // GET THE PLAYER WITH THE min order sql query
$result_ID_first_player_sql_result = mysqli_query($db, $sql_get_players_of_game); // store first players id into a variable

$firstrow_result_ID_first_player = mysqli_fetch_assoc($result_ID_first_player_sql_result);
$firstPlayerID = $firstrow_result_ID_first_player['userid'];
$sql_setUP_whoPlays = "INSERT INTO gametowhoplays (gamename, userid) VALUES ('$currentGameName', '$firstPlayerID')";
if ($db->query($sql_setUP_whoPlays) === TRUE) {
        echo "Player with id $firstPlayerID plays first Succeed <p>";
} else {
       echo "INSERT INTO gametowhoplays (gamename, userid) VALUES ('$currentGameName', '$firstPlayerID')". $db->error;
}
?>




<?php
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