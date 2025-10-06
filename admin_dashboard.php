<?php
session_start();
include('db.php');

// Allow only admin users
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch all users
$sql = "SELECT id, username, email, role FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MoodMirror Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #f4f6f9;
    }
    .sidebar {
        width: 220px;
        height: 100vh;
        background-color: #1d3557;
        color: white;
        position: fixed;
        top: 0; left: 0;
        padding-top: 40px;
    }
    .sidebar h2 {
        text-align: center;
        color: #f1faee;
        margin-bottom: 30px;
    }
    .sidebar a {
        display: block;
        color: #f1faee;
        padding: 12px 20px;
        text-decoration: none;
        transition: 0.3s;
    }
    .sidebar a:hover {
        background-color: #457b9d;
    }
    .main {
        margin-left: 220px;
        padding: 20px;
    }
    h1 {
        color: #1d3557;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    th {
        background-color: #457b9d;
        color: white;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    .logout-btn {
        display: inline-block;
        background-color: #e63946;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
    }
    .logout-btn:hover {
        background-color: #d62828;
    }
    .action-btn {
        color: #1d3557;
        font-weight: 500;
        text-decoration: none;
        margin-right: 10px;
    }
    .delete-btn {
        color: #e63946;
        text-decoration: none;
    }
</style>
</head>
<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">View Users</a>
    <a href="add_user.php">Add User</a>
    <a href="admin_profile.php">Admin Profile</a>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<div class="main">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h1>
    <h2>All Registered Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td>
                <a href="edit_user.php?id=<?= $row['id'] ?>" class="action-btn">Edit</a>
                <a href="delete_user.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
