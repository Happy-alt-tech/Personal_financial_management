<?php
session_start();
include 'config.php';

if (!isset($_SESSION['name'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$name = $_SESSION['name'];

function fetchData($conn, $incomeTable, $expenseTable, $name, $dateFormat) {
    $query = "
        SELECT DATE_FORMAT(date, '$dateFormat') AS period, category, SUM(amount) AS total, 'income' AS type 
        FROM $incomeTable WHERE name = ? 
        GROUP BY period, category 
        UNION ALL
        SELECT DATE_FORMAT(date, '$dateFormat') AS period, category, SUM(amount) AS total, 'expense' AS type
        FROM $expenseTable WHERE name = ?
        GROUP BY period, category
        ORDER BY period";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $name, $name);
    $stmt->execute();
    $result = $stmt->get_result();

    $labels = [];
    $incomeData = [];
    $expenseData = [];

    while ($row = $result->fetch_assoc()) {
        $label = $row['period'] . ' | ' . $row['category'];
        if (!in_array($label, $labels)) {
            $labels[] = $label;
        }

        if ($row['type'] == 'income') {
            $incomeData[$label] = $row['total'];
        } else {
            $expenseData[$label] = $row['total'];
        }
    }

    $incomeFinal = [];
    $expenseFinal = [];

    foreach ($labels as $label) {
        $incomeFinal[] = $incomeData[$label] ?? 0;
        $expenseFinal[] = $expenseData[$label] ?? 0;
    }

    return ["labels" => $labels, "income" => $incomeFinal, "expense" => $expenseFinal];
}

$daily = fetchData($conn, "income_category", "expense_category", $name, "%Y-%m-%d");
$monthly = fetchData($conn, "income_category", "expense_category", $name, "%Y-%m");
$yearly = fetchData($conn, "income_category", "expense_category", $name, "%Y");

$response = [
    "daily" => $daily,
    "monthly" => $monthly,
    "yearly" => $yearly
];

echo json_encode($response);
?>
