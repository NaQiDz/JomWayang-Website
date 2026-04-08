<?php
// Replace with your actual database credentials
$servername = "localhost";  // Your database server (usually localhost)
$username = "root";         // Your MySQL username (root for XAMPP)
$password = "";             // Your MySQL password (leave blank for XAMPP)
$dbname = "projectweb";     // Your database name

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
