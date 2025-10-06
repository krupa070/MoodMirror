<?php
session_start();
include('db.php');

// Allow only admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch admin details
$admin_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Profile - MoodMirror</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f6f9;
    margin: 0;
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
}
.sidebar a {
    display: block;
    color: #f1faee;
    padding: 12px 20px;
    text-decoration: none;
}
.sidebar a:hover {
    background-color: #457b9d;
}
.main {
    margin-left: 220px;
    padding: 40px;
}
.profile-card {
    background: white;
    padding: 30px;
    border-radius: 10px;
    max-width: 400px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.profile-card h2 {
    color: #1d3557;
    margin-bottom: 20px;
}
.profile-field {
    margin-bottom: 15px;
}
.profile-field strong {
    color: #457b9d;
}
.edit-btn {
    background-color: #1d3557;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.edit-btn:hover {
    background-color: #457b9d;
}
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">View Users</a>
    <a href="add_user.php">Add User</a>
    <a href="admin_profile.php">Admin Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h1>Admin Profile 👤</h1>
    <div class="profile-card">
        <h2><?= htmlspecialchars($admin['username']) ?></h2>
        <div class="profile-field"><strong>Email:</strong> <?= htmlspecialchars($admin['email']) ?></div>
        <div class="profile-field"><strong>Role:</strong> <?= htmlspecialchars($admin['role']) ?></div>
        <a href="edit_user.php?id=<?= $admin_id ?>"><button class="edit-btn">Edit Profile</button></a>
    </div>
</div>

</body>
</html>
