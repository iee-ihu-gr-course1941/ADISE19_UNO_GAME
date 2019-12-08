<?php

include('../server.php');


$sql = "CREATE TABLE gametoorder (
    gameid int(11) NOT NULL ,
    userid int(11) NOT NULL ,
    playerorder int(11) NOT NULL 
    )
";

if ($db->query($sql) === TRUE) {
    echo "gametoorder table created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
?>