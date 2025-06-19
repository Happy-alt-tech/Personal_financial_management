<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_form WHERE name='$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            if ($row['status'] == 'approved') {
                echo "Login successful! Welcome, " . $row['name'];
            } else {
                echo "Your account is pending approval from admin.";
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
