<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start session to access user data

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfm";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['name'])) {
    die("Error: User is not logged in.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Escape input to prevent SQL injection
    $name = $conn->real_escape_string($_SESSION['name']); // Fetch name from session
    $feedback_text = $conn->real_escape_string($_POST['feedback_text']); // FIXED name
    $rating = (int)$_POST['rating']; // FIXED name

    // Insert data into the database
    $sql = "INSERT INTO feedback (name, feedback_text, rating) 
            VALUES ('$name', '$feedback_text', $rating)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Feedback submitted successfully!');
                window.location.href = 'feedback.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
