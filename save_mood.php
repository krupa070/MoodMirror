<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include the entry database connection
include('entry_db.php');

// Get logged-in user's ID
$user_id = $_SESSION['user_id'];

// Process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mood = $_POST['mood'];
    $entry = $_POST['entry'];
    $tags = $_POST['tags'];

    // Prepare and execute insert statement
    $stmt = $conn->prepare("INSERT INTO moods (user_id, mood, entry, tags) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $mood, $entry, $tags);

    if ($stmt->execute()) {
          header("Location: history.php");
        // Optionally, redirect back to entry page
        // header("Location: entry.php?success=1");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
