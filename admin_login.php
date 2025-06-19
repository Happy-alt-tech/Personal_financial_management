<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Connect to database
        $conn = new mysqli('localhost', 'root', '', 'PFM');

        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }

        // Prepared statement to fetch user
        $stmt = $conn->prepare("SELECT * FROM admin_login WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password); // In production, hash and compare passwords!
        $stmt->execute();
        $result = $stmt->get_result();

        
        if ($result->num_rows > 0) {
            $_SESSION['admin_name'] = $username;
            echo "<script>
                    alert('✅ Admin Login successful!');
                    window.location.href = 'admin_dashboard.html';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('❌ Invalid credentials. Try again.');
                    window.location.href = 'admin_login.html';
                  </script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>
                alert('Please fill both fields.');
                window.location.href = 'admin_login.html';
              </script>";
    }
} else {
    header("Location: admin_login.html");
    exit();
}
?>
