<?php


include('../server.php');
$isAdmin =  $_SESSION['isAdmin'];

if ($isAdmin == true) {
    echo "<button id='buttonStart' onclick='buttonStartDidClick()'> Start </button>";
} 
?>