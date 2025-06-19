<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root'; // Change if necessary
$pass = ''; // Change if necessary
$db = 'pfm';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT first_name, last_name, email, phone FROM user_register WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Update account details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_account'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $update_sql = "UPDATE user_register SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $user_id);
        $stmt->execute();
        $stmt->close();
        
        header("Location: settings.php");
        exit();
    } elseif (isset($_POST['update_security'])) {
        if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $update_sql = "UPDATE user_register SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("si", $hashed_password, $user_id);
                $stmt->execute();
                $stmt->close();
            }
        }
        header("Location: settings.php");
        exit();
    }
}
?>
