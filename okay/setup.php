<?php
include 'config.php'; // Include the database configuration

// Create connection
$conn = mysqli_connect($server, $username, $passwords, $database);

// Check connection
if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

// Create database if it doesn't exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($database);

// SQL to create users table
$sql_create_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(30) NOT NULL,
    lname VARCHAR(30) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    passwords VARCHAR(255) NOT NULL
)";

// Execute query to create table
if ($conn->query($sql_create_table) === TRUE) {
    echo "Table users created successfully\n";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
