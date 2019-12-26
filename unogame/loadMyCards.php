<?php

include('../server.php');

$currentGameName = $_SESSION['gamename'];
$currentPlayerUserName = $_SESSION['username'];


// First we check if game has started !
$sql_get_if_gameStarted = "SELECT * from games where gamename = '$currentGameName'";
$sqlResult_ID_sql_get_if_gameStarted = mysqli_query($db, $sql_get_if_gameStarted);
$sql_result_sql_get_if_gameStarted_firstRow = mysqli_fetch_assoc($sqlResult_ID_sql_get_if_gameStarted);
$isGameStarted = $sql_result_sql_get_if_gameStarted_firstRow['started'];
$usersJSONABLEArray = new ArrayObject();
if ($isGameStarted == true) {

    // First we get the user id from users
    $sql_get_userID = "SELECT id from users where username = '$currentPlayerUserName'";
    $sqlResult_get_userID = mysqli_query($db, $sql_get_userID);
    $sql_result_sqlResult_get_userID_firstRow = mysqli_fetch_assoc($sqlResult_get_userID);
    $currentUserID = $sql_result_sqlResult_get_userID_firstRow['id'];



    // Now we get all the card ids from the table userid card assotiation

    $sql_select_ordered_cards = "SELECT * FROM useridcardassotiation where userid = '$currentUserID' and gamename = '$currentGameName'";
    $result_select_ordered_cards = mysqli_query($db, $sql_select_ordered_cards);
    while ($row = mysqli_fetch_assoc($result_select_ordered_cards)) {

         // Now for each card id we get the card properties
         $tmp_cardID = $row['cardid'];

         $sql_getCardProperties = "SELECT * from cards where cardid = '$tmp_cardID'";
         $sqlResult_getCardProperties = mysqli_query($db, $sql_getCardProperties);
         $sql_result_getCardProperties_firstRow = mysqli_fetch_assoc($sqlResult_getCardProperties);

         $tmpCardValue = $sql_result_getCardProperties_firstRow['value'];
         $tmpCardColor = $sql_result_getCardProperties_firstRow['color'];

         $cardResourceURL = "Assets/cards/".$tmpCardValue."_".$tmpCardColor.".png";
         $usersJSONABLEArray->append(array('imageSourceURL'=>$cardResourceURL,'cardid'=>$tmp_cardID));
         //echo "<img class='currentCardImage' onclick='didSelectImage($tmp_cardID)' width='120px' src='$cardResourceURL' alt='last played card'>";
    }
echo json_encode($usersJSONABLEArray);



}





?>