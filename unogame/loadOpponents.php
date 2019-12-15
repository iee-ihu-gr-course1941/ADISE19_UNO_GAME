<?php
include('../server.php');

$currentGameName = $_SESSION['gamename'];
$currentPlayerUserName = $_SESSION['username'];

//echo "<h3>";
//echo "gameName: ";
//echo $currentGameName;
//echo "</h3>";

$sql_get_if_gameStarted = "SELECT * from games where gamename = '$currentGameName'";
$sqlResult_ID_sql_get_if_gameStarted = mysqli_query($db, $sql_get_if_gameStarted);
$sql_result_sql_get_if_gameStarted_firstRow = mysqli_fetch_assoc($sqlResult_ID_sql_get_if_gameStarted);
$isGameStarted = $sql_result_sql_get_if_gameStarted_firstRow['started']; // With this check we make sure that when admin reloads the page he will not see the start button again

if ($isGameStarted == false) {
    $sql = "SELECT * FROM gametousersconnection where gameName = '$currentGameName'";
    $result = mysqli_query($db, $sql);
    while ($row = mysqli_fetch_assoc($result)) {

        $opponentID = $row['userid'];
        $sql = "SELECT * FROM users where id = '$opponentID'";
        $newResult = mysqli_query($db, $sql);
        $firstrow = mysqli_fetch_assoc($newResult);
        $username = $firstrow['username'];
        echoPlayer($username,false,0);
    }
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
                $sql_select_current_player = "SELECT * FROM gametowhoplays where gamename = '$currentGameName'";
                $sql_select_current_player_result = mysqli_query($db, $sql_select_current_player);
                $sql_select_current_player_result_firstRow = mysqli_fetch_assoc($sql_select_current_player_result);
                $currentPlayerID = $sql_select_current_player_result_firstRow['userid'];
                $isThisUsersOrder = false;
                if (strcmp($currentPlayerID, $userID) == true) {
                    $isThisUsersOrder = true;
                }


                // Now we get the number of cards that the user has
                $sql_count_player_cards = "SELECT count(*) as total from useridcardassotiation where userid = '$userID'";
                $sql_count_player_cards_result = mysqli_query($db, $sql_count_player_cards);
                $count_data = mysqli_fetch_assoc($sql_count_player_cards_result);
                $number_of_cards = $count_data['total'];


                echoPlayer($username, $isThisUsersOrder, $number_of_cards);

            }


    }
}

function echoPlayer($username, $playing = false, $numberOfCards = 0) {
    $currentPlayerCardtype = "currentPlayerCard";
    if ($playing == true) {
        $currentPlayerCardtype = "card";
    }
    echo "<div class='parentsParent'>";
    echo "<div class='aParent'>";
    echo "<div class='$currentPlayerCardtype'>";
    echo "<img src='Assets/user.png' alt='Avatar' class = 'profileImage'>";
    echo "<div class='container'>";
    echo "<h3><b>";
    echo "$username";
    echo "</b></h3>";
    echo "<div class='testContainer'>";
    echo "<div>";
    echo "<img src='Assets/uno_placeholder.png' alt='Uno' class='unoImage'>";
    echo "</div>";
    echo "<div>";
    echo "<h1>$numberOfCards</h1>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

?>

