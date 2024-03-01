<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
$usernameOrEmail = $_POST['username'];
$password = $_POST['password'];

// Perform SQL query to check login credentials
$sql = "SELECT * FROM users WHERE (username = '$usernameOrEmail' OR email = '$usernameOrEmail') AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
    echo "Login successful"; // You can customize this message or redirect the user to another page
} else {
    // Login failed
    echo "Invalid username/email or password"; // You can customize this message or redirect the user to the login page
}

$conn->close();
?>
