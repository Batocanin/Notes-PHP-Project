<?php

session_start();
ob_start();

$host = 'localhost';
$username  = 'root';
$password = '';
$db = 'notes';

$conn = mysqli_connect($host, $username, $password, $db);
if(!$conn) {
    die('Failed connect to database!');
}

?>