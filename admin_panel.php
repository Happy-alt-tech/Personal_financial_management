<?php
include 'db.php';

// Fetch pending users (fix: properly define $sql and $result)
$sql = "SELECT * FROM user_form WHERE status='pending'";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Debugging ke liye error print karega
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #4CAF50;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1e1e1e;
            color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #4CAF50;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #2a2a2a;
            color: #4CAF50;
            text-transform: uppercase;
        }

        td {
            background-color: #1a1a1a;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            padding: 5px 10px;
            border: 1px solid #4CAF50;
            border-radius: 3px;
            transition: background 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #4CAF50;
            color: black;
        }
    </style>
</head>
<body>
    <h2>Pending Users</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <a href="approve_user.php?id=<?php echo $row['id']; ?>">Approve</a>
                <a href="reject_user.php?id=<?php echo $row['id']; ?>">Reject</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
