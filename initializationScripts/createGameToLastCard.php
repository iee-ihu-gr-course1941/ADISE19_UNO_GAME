<?php

include('../server.php');


$sql = "CREATE TABLE game_to_last_card (
    gamename VARCHAR(100) NOT NULL ,
    lastCardId INT NOT NULL)
";


if ($db->query($sql) === TRUE) {
    echo "Table game_to_last_card created successfully";
} else {
    echo "Error creating table: " . $db->error;
}

?>