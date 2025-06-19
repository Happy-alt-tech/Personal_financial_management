<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'pfm') or die('Connection failed');

// Fetch users from the user_form table
$users_query = "SELECT * FROM user_form";
$users_result = mysqli_query($conn, $users_query);

// Delete user functionality
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $id = $_GET['delete_id']; // 'id' field को सही तरीके से पकड़ें
    $delete_user_query = "DELETE FROM user_form WHERE id = '$id'";
    mysqli_query($conn, $delete_user_query);
    header('Location: ' . $_SERVER['PHP_SELF']); // डिलीट के बाद पेज रिफ्रेश करें
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid white;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .actions button {
            background-color: #008000;
            color: white;
            border: none;
            padding: 5px 10px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        .actions button.delete {
            background-color: red;
        }
        .actions button.profile {
            background-color: blue;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            color: black;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 350px;
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: red;
        }
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #008000;
            margin: 10px auto;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="logout.php"><i class="fa-solid fa-right-to-bracket"></i></a>
    </div>

    
    <div class="main-content">
        <div class="card">
            <h2>User Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($users_result)) { ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <img src="uploaded_img/<?php echo htmlspecialchars($user['image']); ?>" alt="Profile" width="50">
                            </td>
                            <td>
                                <a href="?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <button class="delete-btn">Delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
