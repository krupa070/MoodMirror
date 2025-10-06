<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodMirror - Your Emotional Wellness</title>
    <meta name="description" content="MoodMirror helps you track, understand, and improve your emotional wellness with personalized support.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>">
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

            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="home" class="hero-section">
            <div class="container">
                <div class="hero-grid">
                    <div class="hero-content">
                        <h2 class="hero-title">
                            Welcome Back, 
                            <span class="gradient-text"><?php echo htmlspecialchars($username); ?>!</span>
                        </h2>
                        <p class="hero-subtitle">
                            Track your moods, explore insights, and stay consistent with your emotional wellness journey.
                        </p>
                        <div class="hero-buttons">
                            <button class="btn btn-primary" onclick="window.location.href='entry.php'">Mood Entry</button>
                            <button class="btn btn-outline" onclick="window.location.href='history.php'">View History</button>
                        </div>
                    </div>
                    
                    <div class="hero-image-container">
                        <div class="hero-glow"></div>
                        <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&h=600&fit=crop" 
                             alt="MoodMirror Illustration" 
                             class="hero-image">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section (same content as guest page, dummy links) -->
        <section id="features" class="features-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        Everything You Need for 
                        <span class="gradient-text">Emotional Wellness</span>
                    </h2>
                    <p class="section-subtitle">
                        Powerful features designed to help you understand and improve your emotional health
                    </p>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Daily Mood Tracking</h3>
                        <p class="feature-description">Log your emotions effortlessly with our intuitive interface and visual mood scales.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Insightful Analytics</h3>
                        <p class="feature-description">Discover patterns and trends in your emotional wellness with beautiful charts and reports.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Smart Reminders</h3>
                        <p class="feature-description">Gentle notifications to help you stay consistent with your mood tracking routine.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Private & Secure</h3>
                        <p class="feature-description">Your data is encrypted and completely private. We take your security seriously.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">What Our Users Say</h2>
                    <p class="section-subtitle">
                        Join thousands of people who have improved their emotional wellness with MoodMirror
                    </p>
                </div>

                <div class="testimonials-grid">
                    <div class="testimonial-card">
                        <div class="stars">★★★★★</div>
                        <p class="testimonial-content">
                            "MoodMirror has transformed how I understand my emotions. The insights have been life-changing!"
                        </p>
                        <div class="testimonial-author">
                            <p class="author-name">Sarah Johnson</p>
                            <p class="author-role">Teacher</p>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="stars">★★★★★</div>
                        <p class="testimonial-content">
                            "The analytics are incredible. I can finally see patterns in my mood and take action before things get difficult."
                        </p>
                        <div class="testimonial-author">
                            <p class="author-name">Michael Chen</p>
                            <p class="author-role">Software Engineer</p>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="stars">★★★★★</div>
                        <p class="testimonial-content">
                            "As someone who works in a high-stress environment, MoodMirror helps me stay balanced and aware of my mental health."
                        </p>
                        <div class="testimonial-author">
                            <p class="author-name">Emily Rodriguez</p>
                            <p class="author-role">Healthcare Worker</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section id="team" class="team-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        Meet Our <span class="gradient-text">Expert Team</span>
                    </h2>
                    <p class="section-subtitle">
                        Dedicated professionals committed to your emotional wellness
                    </p>
                </div>

                <div class="carousel-container">
                    <div class="carousel-track-container">
                        <div class="carousel-track" id="carouselTrack">
                            <div class="team-card">
                                <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Dr. Emily Watson" class="team-photo">
                                <h3 class="team-name">Dr. Emily Watson</h3>
                            </div>
                            <div class="team-card">
                                <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Dr. James Miller" class="team-photo">
                                <h3 class="team-name">Dr. James Miller</h3>
                            </div>
                            <div class="team-card">
                                <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="Sarah Anderson" class="team-photo">
                                <h3 class="team-name">Sarah Anderson</h3>
                            </div>
                            <!-- Add more team members as needed -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container footer-container">
            <p class="footer-text">© 2025 MoodMirror. All rights reserved.</p>
        </div>
    </footer>

    <script src="index.js?v=<?php echo time(); ?>"></script>
</body>
</html>
