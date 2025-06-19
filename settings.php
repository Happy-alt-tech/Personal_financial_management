<?php
session_start();
include 'config.php'; // Database connection file

$user_id = $_SESSION['user_id'];

// Fetch user data
$query = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die(mysqli_error($conn));
$user = mysqli_fetch_assoc($query);

// Handle Account Update
if(isset($_POST['update_account'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    mysqli_query($conn, "UPDATE `user_form` SET name = '$first_name $last_name', email = '$email', phone = '$phone' WHERE id = '$user_id'") or die(mysqli_error($conn));
    $message = "Account updated successfully!";
}

// Handle Password Update
if(isset($_POST['update_security'])) {
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    if($new_password != $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        mysqli_query($conn, "UPDATE `user_form` SET password = '$new_password' WHERE id = '$user_id'") or die(mysqli_error($conn));
        $message = "Password updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: "montserrat-regular";
            background-image: url("http://localhost/PHP/simple_futuristic_network_design.jpg");
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: rgb(60, 255, 0);
        }
        .settings-menu {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }
        .settings-menu button {
            padding: 10px 20px;
            background: transparent;
            border: 2px solid white;
            color: white;
            border-radius: 20px;
            cursor: pointer;
            transition: 0.3s;
        }
        .settings-menu button:hover {
            background: white;
            color: black;
        }
        .settings-form {
            width: 80%;
            max-width: 500px;
            display: none;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
        }
        input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        button.save-btn {
            margin-top: 20px;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        button.save-btn:hover {
            background: #45a049;
        }
        .active {
            display: flex;
        }
        .hidden {
            display: none;
        }
        .message {
            background: #000;
            color: lime;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
    <script>
        function showSection(section) {
            document.getElementById('account-settings').classList.remove('active');
            document.getElementById('security-settings').classList.remove('active');
            document.getElementById(section).classList.add('active');
        }

        function toggleForgotPassword() {
            let fields = document.getElementById('forgot-password-fields');
            fields.classList.toggle('hidden');
        }
    </script>
</head>
<body>

    <div class="settings-menu">
        <button onclick="showSection('account-settings')">Account</button>
        <button onclick="showSection('security-settings')">Security</button>
    </div>

    <?php if(isset($message)) { echo "<div class='message'>$message</div>"; } ?>

    <form method="POST" class="settings-form active" id="account-settings">
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars(explode(' ', $user['name'])[0] ?? ''); ?>" required>
        
        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars(explode(' ', $user['name'])[1] ?? ''); ?>" required>
        
        <label>Email Address:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        
        <label>Phone Number:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
        
        <button type="submit" name="update_account" class="save-btn">Update</button>
    </form>
    
    <form method="POST" class="settings-form" id="security-settings">
        <button type="button" onclick="toggleForgotPassword()" class="save-btn">Forgot Password?</button>
        
        <div id="forgot-password-fields" class="hidden">
            <label>New Password:</label>
            <input type="password" name="new_password">
            
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password">
            
            <button type="submit" name="update_security" class="save-btn">Update Password</button>
        </div>
    </form>

</body>
</html>
