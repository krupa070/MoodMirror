<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = ""; // change if your XAMPP has a password
$dbname = "mywebsite";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch mood counts for the user
$sql = "SELECT mood, COUNT(*) AS count FROM moods WHERE user_id = ? GROUP BY mood";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$moodData = [
    'happy' => 0,
    'sad' => 0,
    'angry' => 0,
    'excited' => 0,
    'calm' => 0,
    'anxious' => 0
];

while ($row = $result->fetch_assoc()) {
    $moodData[$row['mood']] = $row['count'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MoodMirror - Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>">
  <style>
    .chart-container {
        width: 80%;
        max-width: 800px;
        margin: 50px auto;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="container header-container">
      <div class="logo">
        <h1>MoodMirror 🌸</h1>
      </div>
      <nav class="nav-desktop">
          <a href="index.php" class="nav-link">Home</a>
        <a href="entry.php" class="nav-link">Mood Entry</a>
            <a href="history.php" class="nav-link">Mood history</a>
             <a href="dashboard.php" class="nav-link">Mood history</a>

        <span class="nav-link">Hello, <?php echo htmlspecialchars($username); ?>!</span>
        <button class="btn btn-outline" onclick="window.location.href='logout.php'">Logout</button>
      </nav>
    </div>
  </header>

  <!-- Mood Dashboard -->
  <main>
    <div class="chart-container">
      <h2>Your Mood Dashboard</h2>
      <canvas id="moodChart"></canvas>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('moodChart').getContext('2d');

    const data = {
      labels: ['Happy', 'Sad', 'Angry', 'Excited', 'Calm', 'Anxious'],
      datasets: [{
        label: 'Number of Entries',
        data: [
          <?php echo $moodData['happy']; ?>,
          <?php echo $moodData['sad']; ?>,
          <?php echo $moodData['angry']; ?>,
          <?php echo $moodData['excited']; ?>,
          <?php echo $moodData['calm']; ?>,
          <?php echo $moodData['anxious']; ?>
        ],
        backgroundColor: [
          '#FFD700', // Happy - gold
          '#1E90FF', // Sad - blue
          '#FF4500', // Angry - red
          '#32CD32', // Excited - green
          '#9370DB', // Calm - purple
          '#FF69B4'  // Anxious - pink
        ],
        borderColor: '#fff',
        borderWidth: 1
      }]
    };

    const config = {
      type: 'bar',
      data: data,
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          },
          title: {
            display: true,
            text: 'Mood Entries Over Time',
            font: {
                size: 20
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision:0
            }
          }
        }
      },
    };

    new Chart(ctx, config);
  </script>
</body>
</html>
