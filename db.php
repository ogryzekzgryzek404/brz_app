<?php
define('HASH_SECRET', 'Dk39sLQpX8mZ72VwA1F0R5JYtCzKPHnBvRmEU9x4aW6e');

$host = 'localhost';
$dbname = 'main_db';
$username = 'sa';
$password = 'KochamMCBardzo';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
