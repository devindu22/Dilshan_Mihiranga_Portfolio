<?php
$host = 'sql200.infinityfree.com';
$dbname = 'if0_41050261_dilshan';
$username = 'if0_41050261'; 
$password = 'U2PmjRcTA6k'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("set names utf8mb4");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>