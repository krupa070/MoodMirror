<?php
include('db.php');

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Check if email already exists
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already registered! Please use another.";
    } else {
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $success = "Account created successfully! Redirecting to login...";
            header("refresh:2;url=login.php");
        } else {
            $error = "Error creating account. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - MoodMirror 💭</title>
  <link rel="stylesheet" href="login.css?v=5" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <!-- ===== Header ===== -->
  <header class="header">
    <div class="container header-container">
      <h1 class="logo">  MoodMirror 💭</h1>
      <nav>
        <a href=""></a>
      </nav>
    </div>
  </header>

  <!-- ===== Register Section ===== -->
  <section class="login-section">
    <div class="login-card">
      <h2>MoodMirror 💭</h2>
      <p>Create your account ✨</p>

      <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
      <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>

      <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
      </form>

      <div class="login-bottom">
        Already have an account? <a href="login.php">Login here</a>
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
