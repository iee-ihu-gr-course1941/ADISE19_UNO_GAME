<?php
include('../server.php');
include('./globalFunctions.php');

$currentGameName = $_SESSION['gamename'];
$currentPlayerUserName = $_SESSION['username'];


// First we check if game has started !
$sql_get_if_gameStarted = "SELECT * from games where gamename = '$currentGameName'";
$sqlResult_ID_sql_get_if_gameStarted = mysqli_query($db, $sql_get_if_gameStarted);
$sql_result_sql_get_if_gameStarted_firstRow = mysqli_fetch_assoc($sqlResult_ID_sql_get_if_gameStarted);
$isGameStarted = $sql_result_sql_get_if_gameStarted_firstRow['started'];


if ($isGameStarted == true) {
    echo "<img width='120px' src='Assets/uno_placeholder.png' alt='Pick a card'>"; // The deck of cards

    // Now we get the last played card to display it to the center
    $sql_get_lastPlayedCard = "SELECT lastCardId FROM game_to_last_card where gamename = '$currentGameName'";
    $sqlResult_sql_get_lastPlayedCard = mysqli_query($db, $sql_get_lastPlayedCard);
    $sql_result_get_lastPlayedCard_firstRow = mysqli_fetch_assoc($sqlResult_sql_get_lastPlayedCard);
    $lastPlayedCardID = $sql_result_get_lastPlayedCard_firstRow['lastCardId'];

    // Now in lastPlayedCardID variable we have the id of the last played card
    // and we will get the card data from cards table based on the card id

    $sql_get_cardID_data_fromCards = "SELECT * from cards where cardid = '$lastPlayedCardID'";
    $sqlResult_get_cardID_data_fromCards = mysqli_query($db, $sql_get_cardID_data_fromCards);
    $sql_result_get_cardID_data_fromCards_firstRow = mysqli_fetch_assoc($sqlResult_get_cardID_data_fromCards);

    $lastCardValue = $sql_result_get_cardID_data_fromCards_firstRow['value'];
    $lastCardColor = $sql_result_get_cardID_data_fromCards_firstRow['color'];
    // now on Assets -> cards folder we added the cards with name  value_color.gif
    $cardResourceURL = "Assets/cards/".$lastCardValue."_".$lastCardColor.".gif";
    echo "<img class='currentCardImage' width='120px' src='$cardResourceURL' alt='last played card'>";

    // now we check if the last played card is balader so that we show the selected color in the board
    if (($lastCardValue == "balader") or ($lastCardValue == "baladerAddFour")) {
        $sql_query = "SELECT color from baladerselectedcolor where gamename = '$currentGameName'";
        $sql_query_result = mysqli_query($db, $sql_query);
        $sql_query_result_first_row = mysqli_fetch_assoc($sql_query_result);
        $color = $sql_query_result_first_row['color'];

        echo "<img class='currentPlayingColorInBalader' style='background-color:";
        switch ($color) {
            case "green":
                echo "#30911F";
                break;
            case "red":
                echo "#ff0000";
                break;
            case "blue":
                echo "#89cff0";
                break;
           case "yellow":
                echo "#ffff00";
                break;
        }
       echo "'>";
    }


    echo "<button onClick='didClickPass()'>Pass</button>";
}


?>