<?php
session_start(); // Session start karna zaroori hai

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pfm";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// **Ensure user is logged in**
if (!isset($_SESSION['name'])) {
    die("Error: User not logged in.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // User input validation
    $user_name = $_SESSION['name']; // **Yahan ab sirf logged-in user ka name save hoga**
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';
    $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // **User ki total income fetch karni hai**
    $income_query = "SELECT SUM(amount) AS total_income FROM income_category WHERE name = ?";
    $stmt_income = $conn->prepare($income_query);
    $stmt_income->bind_param("s", $user_name);
    $stmt_income->execute();
    $result_income = $stmt_income->get_result();
    $row_income = $result_income->fetch_assoc();
    $total_income = $row_income['total_income'] ?? 0;
    $stmt_income->close();

    // **User ka total expense fetch karna hai**
    $expense_query = "SELECT SUM(amount) AS total_expense FROM expense_category WHERE name = ?";
    $stmt_expense = $conn->prepare($expense_query);
    $stmt_expense->bind_param("s", $user_name);
    $stmt_expense->execute();
    $result_expense = $stmt_expense->get_result();
    $row_expense = $result_expense->fetch_assoc();
    $total_expense = $row_expense['total_expense'] ?? 0;
    $stmt_expense->close();

    // **Check if new expense exceeds available balance**
    $available_balance = $total_income - $total_expense;

    if ($amount > $available_balance) {
        echo "<script>alert('❌ Error: Expense amount cannot exceed available balance of ₹$available_balance!'); window.location.href='expense_category.html';</script>";
    } else {
        // **Insert Query with Prepared Statement**
        $stmt = $conn->prepare("INSERT INTO expense_category (name, category, amount, date, payment_method, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $user_name, $category, $amount, $date, $payment_method, $description);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Expense category added successfully!'); window.location.href='expense_category.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
