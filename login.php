<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mywebsite"; // replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
  if (password_verify($password, $user["password"])) {
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["role"] = $user["role"]; // Store role in session

    // Redirect based on role
    if ($user["role"] === "admin") {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;


    } else {
      $error = "Incorrect password.";
    }
  } else {
    $error = "No account found with that email.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MoodMirror 💭 - Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>"> <!-- your main site CSS -->
  <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>"> <!-- login page styling -->
</head>

<body>
  <!-- ===== Header ===== -->
  <header class="header">
    <div class="container header-container">
      <div class="logo">
        <h1>MoodMirror 💭</h1>
      </div>
      <nav class="nav-desktop">
          </nav>
    </div>
  </header>

  <!-- ===== Login Section ===== -->
  <section class="login-section">
    <div class="login-card">
      <h2>MoodMirror 💭</h2>
      <p>Welcome back! Please log in </p>

      <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

      <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
      </form>

      <div class="login-bottom">
        Don’t have an account? <a href="register.php">Sign up here</a>
      </div>
    </div>
  </section>

  <!-- ===== Footer ===== -->
  <footer class="footer">
    <div class="container footer-container">
      <p class="footer-text">© 2025 MoodMirror. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
