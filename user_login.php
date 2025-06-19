<?php
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'pfm');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    } else {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM user_registartion WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        
        $result = $stmt->get_result(); // Fetch result
        if ($result->num_rows > 0) {
            echo "<script>alert('login successful!');</script>";
        } else {
            echo "Invalid credentials.";
        }
        
        $stmt->close();
        $conn->close();
    }
?>


