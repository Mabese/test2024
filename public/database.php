<?php
$host = '127.0.0.1'; // Use IP address instead of 'localhost'
$db = 'test2024'; // Replace with your actual database name
$user = 'your_username'; // Replace with your database username
$pass = 'your_password'; // Replace with your database password
$charset = 'utf8mb4';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo 'Database connection successful!';
} catch (PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage();
}
?>
