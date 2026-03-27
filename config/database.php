<?php
$host = "sql100.infinityfree.com";
$dbname = "if0_41492618_quiz";
$username = "if0_41492618";
$password = "S24HlsoJjOibNq";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>