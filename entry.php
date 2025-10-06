<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MoodMirror - Mood Entry</title>
  <meta name="description" content="Log your emotions and thoughts with MoodMirror to track your emotional wellness.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Main theme styles -->
  <link rel="stylesheet" href="index.css?v=2">
  <!-- Page-specific styles -->
  <link rel="stylesheet" href="entry.css?v=1">
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
        <a href="history.php" class="btn btn-outline">Mood Entry</a>
            <a href="history.php" class="btn btn-outline">Mood history</a>
              <a href="dashboard.php" class="btn btn-outline">Mood graph</a>
              <a href="logout.php" class="btn btn-outline">Logout</a>
      </nav>

      <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </header>

  <!-- Mood Entry Section -->
  <main>
    <section id="mood-entry" class="mood-entry-section">
      <div class="container">
        <div class="entry-card">
          <h2 class="section-title gradient-text">🌸 How are you feeling today?</h2>
          <p class="section-subtitle">Write your thoughts and track your mood daily</p>

          <form action="save_mood.php" method="POST" class="entry-form">
            
            <!-- Mood Dropdown -->
            <div class="form-group">
              <label for="mood">Your Mood</label>
              <select name="mood" id="mood" required>
                <option value="">-- Select Mood --</option>
                <option value="happy">😊 Happy</option>
                <option value="sad">😢 Sad</option>
                <option value="angry">😡 Angry</option>
                <option value="excited">🤩 Excited</option>
                <option value="calm">😌 Calm</option>
                <option value="anxious">😰 Anxious</option>
              </select>
            </div>

            <!-- Journal Text -->
            <div class="form-group">
              <label for="entry">Your Thoughts</label>
              <textarea name="entry" id="entry" rows="6" placeholder="Write about your day..." required></textarea>
            </div>

            <!-- Tags -->
            <div class="form-group">
              <label for="tags">Tags (optional)</label>
              <input type="text" name="tags" id="tags" placeholder="e.g. work, family, health">
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary"> Save Mood</button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer id="contact" class="footer">
    <div class="container footer-container">
      <p class="footer-text">© 2024 MoodMirror. All rights reserved.</p>
      
      <div class="social-links">
        <a href="#" class="social-link" aria-label="Facebook">Fb</a>
        <a href="#" class="social-link" aria-label="Twitter">Tw</a>
        <a href="#" class="social-link" aria-label="Instagram">Ig</a>
        <a href="#" class="social-link" aria-label="LinkedIn">In</a>
      </div>
    </div>
  </footer>
</body>
</html>
