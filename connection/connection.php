<?php 

$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "gamebit";
$charset = "utf8mb4";

$pdo = new PDO("mysql:host=$host;dbname=$database;charset=$charset;", $username, $password, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
])

?>