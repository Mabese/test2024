<?php
session_start();

// Define routes
$routes = [
    'admin' => 'admin.php',
    'institute' => 'institute.php',
    'student' => 'student.php',
    'login' => 'login.blade.php'
];

// Get the requested route
$request = isset($_GET['route']) ? $_GET['route'] : '';

// Check if the route exists
if (array_key_exists($request, $routes)) {
    include $routes[$request];
} else {
    include 'index.php'; // Default to home page
}
?>