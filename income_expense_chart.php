<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfm";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income & Expense Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    body {
        background-image: url('white-abstract-simple-uptrend-financial-chart-background_755228-1221.avif'); /* Image ka path */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
</style>

<body>

    <div class="container">
        <h2 class="text-center mb-4">Income Records</h2>
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
                $stmt = $conn->prepare("SELECT date, category, amount FROM income_category WHERE name = ?");
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row["date"]}</td><td>{$row["category"]}</td><td>{$row["amount"]}</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

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
                $stmt = $conn->prepare("SELECT date, category, amount FROM expense_category WHERE name = ?");
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row["date"]}</td><td>{$row["category"]}</td><td>{$row["amount"]}</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <h2 class="text-center mb-4">Financial Summary</h2>
        <?php
        // Fetch Total Income
        $stmt = $conn->prepare("SELECT SUM(amount) AS total FROM income_category WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $income_total = $stmt->get_result()->fetch_assoc()["total"] ?? 0;

        // Fetch Total Expense
        $stmt = $conn->prepare("SELECT SUM(amount) AS total FROM expense_category WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $expense_total = $stmt->get_result()->fetch_assoc()["total"] ?? 0;

        $balance = $income_total - $expense_total;
        ?>
        <table class="table table-bordered">
            <tr><th>Total Income</th><td><?php echo $income_total; ?></td></tr>
            <tr><th>Total Expense</th><td><?php echo $expense_total; ?></td></tr>
            <tr><th>Balance</th><td><?php echo $balance; ?></td></tr>
        </table>
    </div>
    <div class="container">
    <h2 class="text-center mb-4">Financial Graphs</h2>
    
    <canvas id="dailyChart"></canvas>
    <canvas id="monthlyChart"></canvas>
    <canvas id="yearlyChart"></canvas>
</div>

<script>
    async function fetchData() {
        try {
            const response = await fetch('fetch_graph_data.php');
            const data = await response.json();

            if (data.error) {
                console.error(data.error);
                return;
            }

            renderChart('dailyChart', 'Daily Income & Expense', data.daily.labels, data.daily.income, data.daily.expense);
            renderChart('monthlyChart', 'Monthly Income & Expense', data.monthly.labels, data.monthly.income, data.monthly.expense);
            renderChart('yearlyChart', 'Yearly Income & Expense', data.yearly.labels, data.yearly.income, data.yearly.expense);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    function renderChart(canvasId, title, labels, incomeData, expenseData) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Income',
                        backgroundColor: 'green',
                        data: incomeData
                    },
                    {
                        label: 'Expense',
                        backgroundColor: 'red',
                        data: expenseData
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: title
                    }
                }
            }
        });
    }

    fetchData();
</script>


    <script>
        async function fetchData() {
            const response = await fetch('fetch_graph_data.php');
            const data = await response.json();
            console.log(data);
        }
        fetchData();
    </script>

</body>
</html>

<?php