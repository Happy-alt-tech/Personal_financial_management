<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfm"; // Change to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Date,Category,Amount FROM user_expense";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Date</th><th>Category</th><th>Amount</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Date"] . "</td>";
        echo "<td>" . $row["Category"] . "</td>";
        echo "<td>" . $row["Amount"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Expense Records</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "pfm"; 

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT Date, Category, Amount FROM user_expense";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Date"] . "</td>";
                        echo "<td>" . $row["Category"] . "</td>";
                        echo "<td>" . $row["Amount"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No records found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

