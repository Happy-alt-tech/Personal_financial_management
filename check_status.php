<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_email'])) {
    echo json_encode(["status" => "not_logged_in"]);
    exit();
}

$email = $_SESSION['user_email'];
$query = mysqli_query($conn, "SELECT status FROM user_form WHERE email = '$email'");
$result = mysqli_fetch_assoc($query);

if ($result['status'] == 'approved') {
    // अगर यूज़र अप्रूव हो गया, तो सेशन क्लियर कर दें ताकि वह लॉगिन कर सके
    session_destroy();
}

echo json_encode(["status" => $result['status']]);
?>
