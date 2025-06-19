<?php
session_start();
if (!isset($_SESSION['Admin_name'])) {
    echo "<script>
            alert('Please log in first!');
            window.location.href = 'admin_login.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['Admin_name']; ?>!</h1>
    <button onclick="window.location.href='logout.php'">Logout</button>
</body>
</html>
