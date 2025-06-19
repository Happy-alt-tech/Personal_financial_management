<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'pfm') or die('Connection failed');

// Fetch feedback data
$feedback_query = "SELECT * FROM feedback";
$feedback_result = mysqli_query($conn, $feedback_query);

// Delete feedback functionality
if (isset($_GET['delete_feedback_id'])) {
    $feedback_id = $_GET['delete_feedback_id'];
    $delete_feedback_query = "DELETE FROM feedback WHERE id = '$feedback_id'";
    mysqli_query($conn, $delete_feedback_query);
    header('Location: ' . $_SERVER['PHP_SELF']); // Refresh the page after deletion
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            text-align: center;
            display: flex;
        }
        .sidebar {
            width: 20%;
            background-color: #222;
            padding: 20px;
            height: 100vh;
            text-align: left;
        }
        .sidebar h1 {
            color: #fff;
        }
        .sidebar a {
            display: block;
            color: #fff;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #444;
        }
        .main-content {
            width: 80%;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #1a1a1a;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid white;
            padding: 10px;
            text-align: center;
        }
        .delete-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h1>Admin Dashboard</h1>
        <a href="admin_feedback.php">Feedback</a>
    </div>

    <div class="main-content">
        <div class="container">
            <h2>User Feedback</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Feedback Text</th>
                        <th>Rating</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($feedback = mysqli_fetch_assoc($feedback_result)) { ?>
                        <tr>
                            <td><?php echo $feedback['id']; ?></td>
                            <td><?php echo $feedback['name']; ?></td>
                            <td><?php echo $feedback['feedback_text']; ?></td>
                            <td><?php echo $feedback['rating']; ?></td>
                            <td>
                                <a href="?delete_feedback_id=<?php echo $feedback['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this feedback?')">
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
