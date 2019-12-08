<?php

include('../server.php');


$sql = "CREATE TABLE useridcardassotiation (
    userid int(11) NOT NULL ,
    cardid int(11) NOT NULL 
    )
";

if ($db->query($sql) === TRUE) {
    echo "useridcardassotiation table created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
?>