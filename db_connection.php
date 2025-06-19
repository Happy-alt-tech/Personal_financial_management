<?php
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = "";     // Default password is empty for XAMPP
$database = "pfm"; // The database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
