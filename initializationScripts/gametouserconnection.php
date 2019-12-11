<?php
include('../server.php');

$sql = "CREATE TABLE gametousersconnection (
  userid int(11) NOT NULL,
  gameName varchar(100) NOT NULL
)";


if ($db->query($sql) === TRUE) {
    echo "gametousersconnection created successfully";
} else {
    echo "Error creating table: " . $db->error;
}

?>