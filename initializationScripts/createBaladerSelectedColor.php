<?php

include('../server.php');
$sql = "CREATE TABLE baladerSelectedColor (
    gamename VARCHAR(100) NOT NULL ,
    color varchar (100)
    )
";

if ($db->query($sql) === TRUE) {
    echo "baladerSelectedColor table created successfully";
} else {
    echo "Error creating table: " . $db->error;
}


?>