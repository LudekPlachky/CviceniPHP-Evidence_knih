<?php
$servername = "md418.wedos.net";
$username = "w351838_knihy";
$password = "6QKxrHqK";
$dbname = "d351838_knihy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>