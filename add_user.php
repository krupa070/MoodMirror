<?php
session_start();
include('db.php');

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "<p style='color:red;'>Email already exists!</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        if ($stmt->execute()) {
            $message = "<p style='color:green;'>User added successfully!</p>";
        } else {
            $message = "<p style='color:red;'>Error adding user.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add User - Admin</title>
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
form {
    background-color: white;
    padding: 25px;
    border-radius: 10px;
    max-width: 400px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
input, select, button {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button {
    background-color: #1d3557;
    color: white;
    border: none;
    cursor: pointer;
}
button:hover {
    background-color: #457b9d;
}
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">View Users</a>
    <a href="add_user.php">Add User</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h1>Add New User 👤</h1>
    <?= $message ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Add User</button>
    </form>
</div>

</body>
</html>
