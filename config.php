<?php
// Database configuration
$host = 'localhost';
$db_name = 'webtestluser';
$username = 'root'; 
$password = ''; 

// Attempt to connect to the database
try {
    $pdo = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
