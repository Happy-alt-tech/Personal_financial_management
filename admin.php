<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $id = $_POST['user_id'];
    $conn->query("UPDATE users SET status='approved' WHERE id=$id");
}

$pendingUsers = $conn->query("SELECT * FROM users WHERE status='pending'");
$approvedUsers = $conn->query("SELECT * FROM users WHERE status='approved'");
?>

<h2>Pending Users</h2>
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Username</th><th>Action</th></tr>
    <?php while ($row = $pendingUsers->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['username'] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                    <button type="submit" name="approve">Approve</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Approved Users</h2>
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Username</th><th>Email</th></tr>
    <?php while ($row = $approvedUsers->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= $row['email'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
