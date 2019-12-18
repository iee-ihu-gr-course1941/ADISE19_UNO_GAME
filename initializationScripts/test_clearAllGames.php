<?php

    include('../server.php');


    $sql = "DELETE FROM gametowhoPlays";
    if ($db->query($sql) === TRUE) {
    echo "gametowhoPlays cleared successfully <p>";
    }else {
     echo "gametowhoPlays failed on clear<p>";
    }

    $sql = "DELETE FROM games";
    if ($db->query($sql) === TRUE) {
    echo "games cleared successfully<p>";
    }else {
     echo "games failed on clear<p>";
    }

    $sql = "DELETE from gametousersconnection";
    if ($db->query($sql) === TRUE) {
    echo "gametousersconnection cleared successfully<p>";
    } else {
    echo "gametousersconnection failed on clear<p>";
    }

    $sql = "DELETE from useridcardassotiation";
    if ($db->query($sql) === TRUE) {
    echo "useridcardassotiation cleared successfully<p>";
    }else {
     echo "useridcardassotiation failed on clear<p>";
    }

    $sql = "DELETE FROM game_to_last_card";
    if ($db->query($sql) === TRUE) {
     echo "game_to_last_card cleared successfully<p>";
    }else {
      echo "game_to_last_card failed on clear<p>";
    }

    $sql = "DELETE FROM game_to_not_played_cards";
    if ($db->query($sql) === TRUE) {
       echo "game_to_not_played_cards cleared successfully<p>";
    }else {
        echo "game_to_not_played_cards failed on clear<p>";
    }

    $sql = "DELETE FROM gametoorder";
    if ($db->query($sql) === TRUE) {
    echo "gametoorder cleared successfully<p>";
    }else {
    echo "gametoorder failed on clear<p>";
    }

    $sql = "DELETE FROM baladerSelectedColor";
    if ($db->query($sql) === TRUE) {
    echo "baladerSelectedColor cleared successfully<p>";
    }else {
    echo "baladerSelectedColor failed on clear<p>";
    }
?>