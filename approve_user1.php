<?php
include 'db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Update user status
    $sql = "UPDATE users SET status='approved' WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User Approved Successfully!";
        
        // Fetch user email
        $user_query = "SELECT email FROM users WHERE id=$user_id";
        $result = $conn->query($user_query);
        $user = $result->fetch_assoc();
        $to = $user['email'];
        $subject = "Approval Notification";
        $message = "You are accepted by admin.";
        $headers = "From: admin@example.com";

        mail($to, $subject, $message, $headers);

        header("Location: admin_panel.php"); // Redirect to admin panel
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
