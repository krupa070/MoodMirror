<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'mywebsite'); // change DB info
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Handling sort
$sort = $_GET['sort'] ?? 'created_at';
$allowedSort = ['created_at', 'mood'];
if (!in_array($sort, $allowedSort)) $sort = 'created_at';

// Handling tag filter
$tag_filter = $_GET['tag'] ?? '';
$sql = "SELECT * FROM moods WHERE user_id = ?";
$params = [$user_id];
$types = "i";

if ($tag_filter) {
    $sql .= " AND FIND_IN_SET(?, tags)";
    $params[] = $tag_filter;
    $types .= "s";
}

$sql .= " ORDER BY $sort DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MoodMirror - Mood History</title>
<link rel="stylesheet" href="index.css?v=2">
<link rel="stylesheet" href="history.css?v=2">
</head>
<body>
<header class="header">
    <div class="container header-container">
        <div class="logo"><h1>MoodMirror 🌸</h1></div>
        <nav class="nav-desktop">
             <a href="index.php" class="nav-link">Home</a>
        <a href="entry.php" class="nav-link">Mood Entry</a>
            <a href="history.php" class="nav-link">Mood history</a>
             <a href="dashboard.php" class="nav-link">Mood graphy</a>

                <span class="nav-link">Hello, <?php echo htmlspecialchars($username); ?>!</span>
                <button class="btn btn-outline" onclick="window.location.href='logout.php'">Logout</button>
        </nav>
    </div>
</header>

<main>
<section class="history-section">
    <div class="container">
        <h2 class="section-title gradient-text">📖 Your Mood History</h2>

        <div class="history-controls">
            <form method="GET" class="filter-form">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="created_at" <?php if($sort=='created_at') echo 'selected'; ?>>Date</option>
                    <option value="mood" <?php if($sort=='mood') echo 'selected'; ?>>Mood</option>
                </select>

                <label for="tag">Filter by Tag:</label>
                <input type="text" name="tag" id="tag" value="<?php echo htmlspecialchars($tag_filter); ?>" placeholder="Enter tag">
                <button type="submit">Apply</button>
            </form>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <div class="history-grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="history-card">
                        <p class="history-date"><?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></p>
                        <p class="history-mood">Mood: <strong><?php echo htmlspecialchars($row['mood']); ?></strong></p>
                        <p class="history-entry"><?php echo nl2br(htmlspecialchars($row['entry'])); ?></p>
                        <?php if (!empty($row['tags'])): ?>
                            <p class="history-tags">Tags: <?php echo htmlspecialchars($row['tags']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="no-history">No moods found. <a href="entry.php">Add your first mood</a>.</p>
        <?php endif; ?>
    </div>
</section>
</main>

<footer class="footer">
    <div class="container footer-container">
        <p>© 2025 MoodMirror. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>
