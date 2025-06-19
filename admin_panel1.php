<?php
include 'db.php';

// Fetch pending users
$pending_users_query = "SELECT * FROM user_form WHERE status='pending'";
$pending_users_result = $conn->query($pending_users_query);

// Fetch approved users
$approved_users_query = "SELECT * FROM user_form WHERE status='approved'";
$approved_users_result = $conn->query($approved_users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: black;
            color: white;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            margin: auto;
            background: rgba(26, 26, 26, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 255, 0, 0.3);
        }

        h2, h3 {
            border-bottom: 2px solid #008000;
            padding-bottom: 5px;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .user-table th, .user-table td {
            border: 1px solid white;
            padding: 12px;
            text-align: left;
        }

        .user-table th {
            background: linear-gradient(135deg, #004d00, #008000);
            color: white;
        }

        .btn-approve, .btn-reject {
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-transform: uppercase;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-approve {
            background: #00ff00;
            color: black;
        }

        .btn-approve:hover {
            background: #00cc00;
            transform: scale(1.1);
        }

        .btn-reject {
            background: #ff0000;
            color: white;
        }

        .btn-reject:hover {
            background: #cc0000;
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Admin Panel - User Management</h2>
        
        <h3>Pending Users</h3>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $pending_users_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="approve_user.php?id=<?php echo $row['id']; ?>" class="btn-approve">Approve</a>
                            <a href="reject_user.php?id=<?php echo $row['id']; ?>" class="btn-reject">Reject</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Approved Users</h3>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $approved_users_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

</body>
</html>
