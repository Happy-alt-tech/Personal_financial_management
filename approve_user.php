<?php
include 'config.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Database update query
    $update = mysqli_query($conn, "UPDATE `user_form` SET status = 'approved' WHERE id = '$id'");

    if($update){
        echo "<script>alert('User approved successfully!'); window.location.href='admin_panel1.php';</script>";
    } else {
        echo "<script>alert('Failed to approve user!');</script>";
    }
} else {
    echo "<script>alert('Invalid request!');</script>";
}
?>
