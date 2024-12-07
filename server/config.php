<?php

$host = "localhost";
$db_name = "inventory";
$username = "root";
$password = "";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', "message" => "Databse connection failed " . $e->getMessage()]));
}
