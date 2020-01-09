<?php
include('../server.php');
include './globalFunctions.php';

$currentGameName = $_SESSION['gamename'];
$currentPlayerUserName = $_SESSION['username'];


$sql_get_if_gameStarted = "SELECT * from games where gamename = '$currentGameName'";
$sqlResult_ID_sql_get_if_gameStarted = mysqli_query($db, $sql_get_if_gameStarted);
$sql_result_sql_get_if_gameStarted_firstRow = mysqli_fetch_assoc($sqlResult_ID_sql_get_if_gameStarted);
$isGameStarted = $sql_result_sql_get_if_gameStarted_firstRow['started']; // With this check we make sure that when admin reloads the page he will not see the start button again


$usersJSONABLEArray = new ArrayObject();

if ($isGameStarted == false) {
    $sql = "SELECT * FROM gametousersconnection where gameName = '$currentGameName'";
    $result = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_assoc($result)) {

        $opponentID = $row['userid'];
        $sql = "SELECT * FROM users where id = '$opponentID'";
        $newResult = mysqli_query($db, $sql);
        $firstrow = mysqli_fetch_assoc($newResult);
        $username = $firstrow['username'];
        $usersJSONABLEArray->append(array('name'=>$username,'number_of_cards'=>0, 'isPlaying'=>false));
        //echoPlayer($username,false,0);
    }
    echo json_encode($usersJSONABLEArray);
} else {

    // here is the case that the game has started so we select the users form the gametoorder
    $sql_select_ordered_users = "SELECT * FROM gametoorder where gamename = '$currentGameName' ORDER BY playerorder";
    $result_select_ordered_users = mysqli_query($db, $sql_select_ordered_users);
    while ($row = mysqli_fetch_assoc($result_select_ordered_users)) {
            $userID = $row['userid'];
            $userOrder = $row['playerorder'];

            // Now we get the user details
            $sql_select_userDetails = "SELECT * FROM users where id = '$userID'";
            $sql_result_userDetails = mysqli_query($db, $sql_select_userDetails);
            $sql_result_userDetails_firstRow = mysqli_fetch_assoc($sql_result_userDetails);
            $username = $sql_result_userDetails_firstRow['username'];


            // Here we load the opponents on top so we want not to show the current player in the opponents section
            if ($currentPlayerUserName != $username) {
                // check if this opponent is the opponent that currently plays
                $sql_select_current_player = "SELECT 'userid' FROM gametowhoplays where gamename = '$currentGameName'";
                $sql_select_current_player_result = mysqli_query($db, $sql_select_current_player);
                if($sql_select_current_player_result == true) { //check if loadOpponents succeed
                    $sql_select_current_player_result_firstRow = mysqli_fetch_assoc($sql_select_current_player_result);
                    $currentPlayerID = $sql_select_current_player_result_firstRow['userid'];
                    $isThisUsersOrder = false;
                    if (strcmp($currentPlayerID, $userID) == 0) {
                        $isThisUsersOrder = true;
                    }


                    // Now we get the number of cards that the user has
                    $sql_count_player_cards = "SELECT count(*) as total from useridcardassotiation where userid = '$userID' and gamename = '$currentGameName'";
                    $sql_count_player_cards_result = mysqli_query($db, $sql_count_player_cards);
                    $count_data = mysqli_fetch_assoc($sql_count_player_cards_result);
                    $number_of_cards = $count_data['total'];

                    $usersJSONABLEArray->append(array('name'=>$username,'number_of_cards'=>$number_of_cards, 'isPlaying'=>$isThisUsersOrder));
                }
                //echoPlayer($username, $isThisUsersOrder, $number_of_cards);
            }
    }
    echo json_encode($usersJSONABLEArray);
}


?>

