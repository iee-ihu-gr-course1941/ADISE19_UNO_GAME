<?php

include('../server.php');

$sql = "CREATE TABLE userToHasPickedACard (
    gamename varchar(100) NOT NULL ,
    userid int(11) NOT NULL ,
    hasPickedACard Boolean
    )
";

if ($db->query($sql) === TRUE) {
    echo "userToHasPickedACard table created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
?>