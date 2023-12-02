<?php

$host = 'localhost';
$db_name = 'id21596450_food_db';
$user_name = 'id21596450_root';
$user_password = 'Example1.';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $user_name, $user_password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>