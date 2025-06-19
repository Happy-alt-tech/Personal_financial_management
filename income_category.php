<?php
session_start(); // ✅ Session Start Karna Zaroori Hai

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfm";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// **Check if user is logged in**
if (!isset($_SESSION['name'])) {
    die("Error: User is not logged in.");
}

// **Get logged-in user's name from session**
$user_name = $_SESSION['name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // User input validation
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';
    $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // **Insert Query with Prepared Statement (Security Improvement)**
    $stmt = $conn->prepare("INSERT INTO income_category (name, category, amount, date, payment_method, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $user_name, $category, $amount, $date, $payment_method, $description);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Income category added successfully!')</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
