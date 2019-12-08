<?php
include('../server.php');

$sql = "CREATE TABLE gametousersconnection (
  userid int(11) NOT NULL,
  gameid int(11) NOT NULL
)";


if ($db->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $db->error;
}

?>