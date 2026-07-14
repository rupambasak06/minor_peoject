<?php
// config.php - Database configuration
session_start();

$host = 'localhost';
$dbname = 'u396784983_minor';
$user = 'u396784983_minor';
$pass = 'MinorProject@2026';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123');

// No closing ?> 