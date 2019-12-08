<?php

include('../server.php');


$sql = "DROP TABLE cards";
$db->query($sql);

$sql = "CREATE TABLE cards (
    cardid int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    value VARCHAR(100) NOT NULL ,
    color Varchar (20) NOT NULL 
    )
";

if ($db->query($sql) === TRUE) {
    echo "Cards table created successfully";
} else {
    echo "Error creating table: " . $db->error;
}


$numbers = ["1","2","3","4","5","6","7","8","9","plus2","loseOrder","switchOrder"];
$colors = ["red", "blue", "yellow", "green"];

for ($count = 0; $count < 2; $count++) {
    for ($i = 0; $i < count($numbers); $i++) { /* All numbers exists 2 times in the deck per color */
        for ($j = 0; $j < count($colors); $j++) {
            $sql = "INSERT INTO cards (value, color) VALUES ('$numbers[$i]', '$colors[$j]')";
            $db->query($sql);
        }
    }
}
for ($j = 0; $j < count($colors); $j++){ /* 0 exists one time in the deck based on rules */
    $sql = "INSERT INTO cards (value, color) VALUES ('0', '$colors[$j]')";
    $db->query($sql);
}

$extraCards = ["balader", "baladerAddFour"];

for ($i= 0; $i < 4; $i++) {
    for ($j = 0; $j < count($extraCards); $j++) { /* balader and balader add 4 exists 4 times each card in the deck */
        $sql = "INSERT INTO cards (value, color) VALUES ('$extraCards[$j]', '$extraCards[$j]')";
        $db->query($sql);
    }
}


?>