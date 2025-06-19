<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

echo "<script>
        alert('Admin Logged Out Successfully!');
        window.location.href = 'admin_login.php';
      </script>";
exit();
?>
