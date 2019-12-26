<?php


    include('../server.php');
    $isAdmin =  $_SESSION['isAdmin'];
    $gameName = $_SESSION['gamename'];

    $sql_get_if_gameStarted = "SELECT * from games where gamename = '$gameName'";
    $sqlResult_ID_sql_get_if_gameStarted = mysqli_query($db, $sql_get_if_gameStarted);
    $sql_result_sql_get_if_gameStarted_firstRow = mysqli_fetch_assoc($sqlResult_ID_sql_get_if_gameStarted);
    $isGameStarted = $sql_result_sql_get_if_gameStarted_firstRow['started']; // With this check we make sure that when admin reloads the page he will not see the start button again


    if ($isAdmin == true && $isGameStarted == false) {
        echo "<button id='buttonStart' onclick='buttonStartDidClick()' class ='btn-grad'> Start </button>";
    }
?>