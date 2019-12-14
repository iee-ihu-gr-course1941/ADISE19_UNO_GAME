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


?>