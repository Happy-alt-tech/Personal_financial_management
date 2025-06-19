<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "pfm";

// MySQL Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Income Categories
$sql_income_category = "SELECT * FROM income_category";
$result_income_category = $conn->query($sql_income_category);

// Fetch Expense Categories
$sql_expense_category = "SELECT * FROM expense_category";
$result_expense_category = $conn->query($sql_expense_category);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Reports</title>
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
        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Reports</h2>

        <!-- Income Categories -->
        <div class="section-title">Income Categories</div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_income_category->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['category'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['amount'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['date'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['payment_method'] ?? '') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Expense Categories -->
        <div class="section-title">Expense Categories</div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_expense_category->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['category'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['amount'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['date'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['payment_method'] ?? '') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
