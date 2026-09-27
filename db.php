<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "blogpostdb";

$conn = new mysqli($server, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
