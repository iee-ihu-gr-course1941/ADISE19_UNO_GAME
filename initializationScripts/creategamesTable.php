<?php

include('../server.php');


$sql = "CREATE TABLE games (
    gameid int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    gamename VARCHAR(100) NOT NULL ,
    started BOOLEAN,
    finished BOOLEAN,
    adminid INT NOT NULL)
";


if ($db->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $db->error;
}

?>