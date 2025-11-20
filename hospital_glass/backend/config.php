<?php
// config.php
$DB_HOST = 'localhost';
$DB_NAME = 'hospital_glass';
$DB_USER = 'root';
$DB_PASS = ''; // তোমার MySQL password যদি থাকে বসাও

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    exit("Database connection failed: " . $e->getMessage());
}
