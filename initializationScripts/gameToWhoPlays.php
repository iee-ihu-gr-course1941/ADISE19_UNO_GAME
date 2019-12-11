<?php

include('../server.php');


$sql = "CREATE TABLE gametowhoPlays (
    gamename varchar (100) NOT NULL ,
    userid int(11) NOT NULL
    )
";

if ($db->query($sql) === TRUE) {
    echo "gametowhoPlays table created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
?>