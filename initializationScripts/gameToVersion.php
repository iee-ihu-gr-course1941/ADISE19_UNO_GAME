<?php

include('../server.php');
$sql = "CREATE TABLE gametoVersion (
    gameName varchar (100) NOT NULL ,
    versionNumber int NOT NULL
    )
";

if ($db->query($sql) === TRUE) {
    echo "gametoVersion table created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
?>