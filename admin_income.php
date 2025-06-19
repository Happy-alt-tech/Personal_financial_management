<?php
session_start(); // Start session

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "pfm";

// MySQL Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// **Fetch All Income Records for Admin**
$sql = "SELECT * FROM user_income";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Income Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 90%;
            margin: auto;
            background: #1a1a1a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid white;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #006400;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin - Income Reports</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Payment Method</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['user_id']}</td>
                                <td>{$row['amount']}</td>
                                <td>{$row['date']}</td>
                                <td>{$row['category']}</td>
                                <td>{$row['payment_method']}</td>
                                <td>{$row['description']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
