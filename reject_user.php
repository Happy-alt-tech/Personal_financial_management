<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update status to 'rejected'
    $update_query = "UPDATE user_form SET status='rejected' WHERE id='$id'";
    
    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('User Rejected Successfully!'); window.location.href='admin_panel.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
