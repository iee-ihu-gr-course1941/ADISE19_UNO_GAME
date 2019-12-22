<?php

include('../server.php');


$sql = "CREATE TABLE gameToWinner (
    gameName varchar(100) NOT NULL ,
    winnerID int(11) NOT NULL
    )
";

if ($db->query($sql) === TRUE) {
    echo "gameToWinner table created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
?>