<?php
$user='root';
$pass='';
$host='localhost';
$db = 'uno';


$mysqli = new mysqli($host, $user, $pass, $db,null,'/var/run/mysql.sock');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . 
    $mysqli->connect_errno . ") " . $mysqli->connect_error;
}?>

