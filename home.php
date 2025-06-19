<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('location:login.php');
    exit;
}

// Fetch user details
$fetch = null;
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE user_id = '$user_id'") or die('Query failed');

if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

        :root {
            --blue: #3498db;
            --dark-blue: #2980b9;
            --red: #e74c3c;
            --dark-red: #c0392b;
            --black: #333;
            --white: #fff;
            --light-bg: #eee;
            --box-shadow: 0 5px 10px rgba(0,0,0,.1);
        }

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }

        .container {
            min-height: 100vh;
            background-color: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container .profile {
            padding: 20px;
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            text-align: center;
            width: 400px;
            border-radius: 5px;
        }

        .container .profile img {
            height: 150px;
            width: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 5px;
        }

        .btn {
            background-color: var(--blue);
            color: var(--white);
            padding: 10px 30px;
            border-radius: 5px;
            display: block;
            text-align: center;
            cursor: pointer;
            font-size: 20px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: var(--dark-blue);
        }

        .delete-btn {
            background-color: var(--red);
        }

        .delete-btn:hover {
            background-color: var(--dark-red);
        }
    </style>

</head>
<body>
    
<div class="container">
    <div class="profile">
        <?php if ($fetch): ?>
            <img src="<?= !empty($fetch['image']) ? 'uploaded_img/'.$fetch['image'] : 'images/default-avatar.png' ?>" alt="Profile Picture">
            <h3><?= htmlspecialchars($fetch['name']); ?></h3>
        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>

        <a href="update_profile.php" class="btn">Update Profile</a>
        <a href="home.php?logout=1" class="delete-btn">Logout</a>
        <p>New <a href="login.php">Login</a> or <a href="register.php">Register</a></p>
    </div>
</div>

</body>
</html>
