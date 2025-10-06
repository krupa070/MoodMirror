<?php
session_start();
include('db.php');

// Check if admin is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Only admin can access
$email = $_SESSION["username"] ?? '';
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user["role"] !== "admin") {
    echo "<h3 style='color:red;text-align:center;'>Access Denied. Admins Only.</h3>";
    exit;
}

// Get user ID to edit
if (!isset($_GET['id'])) {
    die("No user selected.");
}

$id = $_GET['id'];

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$editUser = $result->fetch_assoc();

if (!$editUser) {
    die("User not found.");
}

// Update user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    $update = $conn->prepare("UPDATE users SET username=?, email=?, role=? WHERE id=?");
    $update->bind_param("sssi", $username, $email, $role, $id);
    $update->execute();

    header("Location: admin_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit User - Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <h2 style="text-align:center;">Edit User</h2>
  <form method="POST" style="max-width:400px;margin:auto;">
      <label>Username:</label><br>
      <input type="text" name="username" value="<?php echo $editUser['username']; ?>" required><br><br>

      <label>Email:</label><br>
      <input type="email" name="email" value="<?php echo $editUser['email']; ?>" required><br><br>

      <label>Role:</label><br>
      <select name="role">
          <option value="user" <?php if($editUser['role']=='user') echo 'selected'; ?>>User</option>
          <option value="admin" <?php if($editUser['role']=='admin') echo 'selected'; ?>>Admin</option>
      </select><br><br>

      <button type="submit">Update</button>
  </form>
</body>
</html>
