<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'mywebsite');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? 0;

// Fetch existing mood
$stmt = $conn->prepare("SELECT * FROM moods WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$mood = $result->fetch_assoc();

if (!$mood) {
    die("Mood not found or access denied.");
}

// Update mood on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_mood = $_POST['mood'];
    $entry = $_POST['entry'];
    $tags = $_POST['tags'];

    $update = $conn->prepare("UPDATE moods SET mood=?, entry=?, tags=? WHERE id=? AND user_id=?");
    $update->bind_param("sssii", $new_mood, $entry, $tags, $id, $user_id);
    $update->execute();

    header("Location: history1.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Mood - MoodMirror</title>
  <link rel="stylesheet" href="index.css?v=2">
</head>
<body>
  <header class="header">
    <div class="container header-container">
      <div class="logo"><h1>MoodMirror 🌸</h1></div>
      <nav class="nav-desktop">
        <a href="entry.php" class="btn btn-outline">New Entry</a>
        <a href="history1.php" class="btn btn-outline">Mood History</a>
      </nav>
    </div>
  </header>

  <main class="container">
    <h2 class="section-title gradient-text">✏️ Edit Mood Entry</h2>
    <form method="POST" class="entry-form">
      <div class="form-group">
        <label>Mood</label>
        <select name="mood" required>
          <option value="happy" <?php if($mood['mood']=='happy') echo 'selected'; ?>>😊 Happy</option>
          <option value="sad" <?php if($mood['mood']=='sad') echo 'selected'; ?>>😢 Sad</option>
          <option value="angry" <?php if($mood['mood']=='angry') echo 'selected'; ?>>😡 Angry</option>
          <option value="excited" <?php if($mood['mood']=='excited') echo 'selected'; ?>>🤩 Excited</option>
          <option value="calm" <?php if($mood['mood']=='calm') echo 'selected'; ?>>😌 Calm</option>
          <option value="anxious" <?php if($mood['mood']=='anxious') echo 'selected'; ?>>😰 Anxious</option>
        </select>
      </div>

      <div class="form-group">
        <label>Your Thoughts</label>
        <textarea name="entry" rows="6" required><?php echo htmlspecialchars($mood['entry']); ?></textarea>
      </div>

      <div class="form-group">
        <label>Tags</label>
        <input type="text" name="tags" value="<?php echo htmlspecialchars($mood['tags']); ?>">
      </div>

      <button type="submit" class="btn btn-primary">Update Mood</button>
    </form>
  </main>
</body>
</html>
