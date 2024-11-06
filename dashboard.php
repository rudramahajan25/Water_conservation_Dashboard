<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'water_monitor');
$username = $_SESSION['username'];

// Fetch user details from the database
$result = $conn->query("SELECT * FROM users WHERE username='$username'");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Conservation Monitor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>Water Conservation Monitor</h1>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#tips">Water Saving Tips</a></li>
                <li><a href="#dashboard">Dashboard</a></li>
                <li><a href="#impact">Our Impact</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="logout.php">Logout</a></li> <!-- Added a logout option -->
            </ul>
        </nav>
    </header>

    <section id="hero" class="hero">
        <video autoplay muted loop class="hero-video">
            <source src="waterflow.mp4" type="video/mp4">
        </video>
        <div class="hero-text">
            <h2>Start Saving Water Today</h2>
            <p>Join the movement to conserve our most precious resource.</p>
            <a href="#tips" class="btn-primary">Learn How</a>
        </div>
    </section>

    <section id="tips" class="tips">
        <h2>Water Saving Tips</h2>
        <div class="tips-grid">
            <div class="tips-item">
                <img src="Water-Leak.jpeg" alt="Fix Leaks">
                <h3>Fix Leaks</h3>
                <p>Repairing leaks in your home can save thousands of gallons of water annually.</p>
            </div>
            <div class="tips-item">
                <img src="waterimage.jpg" alt="Water Plants Wisely">
                <h3>Water Plants Wisely</h3>
                <p>Water plants early in the morning to reduce evaporation and save water.</p>
            </div>
            <div class="tips-item">
                <img src="dripirrigation.jpg" alt="Drip Irrigation">
                <h3>Install Drip Irrigation</h3>
                <p>Use drip irrigation to water plants more efficiently, reducing water waste.</p>
            </div>
        </div> 
    </section>

    <section id="dashboard" class="dashboard">
        <h2>Your Water Usage Dashboard</h2>
        <p>Monitor and manage your water usage effectively.</p>
        <div id="greeting">
            <h3>Hello, <?php echo $user['name']; ?>!</h3> <!-- Personalized greeting -->
        </div>
        <div class="dashboard-content">
            <div class="live-consumption">
                <h3>Live Consumption</h3>
                <div id="live-consumption-gauge"></div>
            </div>
            <div class="water-usage-chart">
                <canvas id="water-usage-chart"></canvas>
            </div>
        </div>
        <div class="additional-parameters">
            <h3>Additional Parameters</h3>
            <div class="parameters-grid">
                <div class="parameter-item">
                    <img src="month.avif" alt="Monthly Consumption Icon" class="parameter-icon">
                    <div class="parameter-value" id="monthly-consumption">
                        <?php echo $user['monthly_consumption']; ?> litres
                    </div>
                    <div class="parameter-label">Monthly Consumption</div>
                </div>
                <div class="parameter-item">
                    <img src="average.png" alt="Average Daily Consumption Icon" class="parameter-icon">
                    <div class="parameter-value" id="average-consumption">
                        <?php echo $user['average_consumption']; ?> litres/day
                    </div>
                    <div class="parameter-label">Average Daily Consumption</div>
                </div>
                <div class="parameter-item">
                    <img src="calendar.png" alt="Yearly Consumption Icon" class="parameter-icon">
                    <div class="parameter-value" id="yearly-consumption">
                        <?php echo $user['yearly_consumption']; ?> litres
                    </div>
                    <div class="parameter-label">Yearly Consumption</div>
                </div>
            </div>
        </div>
    </section>

    <section id="impact" class="impact">
        <h2>Our Impact</h2>
        <div class="impact-stats">
            <div class="stat-item">
                <h3><span id="Litres-saved" data-target="5000">0</span>+</h3>
                <p>Litres of Water Saved</p>
            </div>
            <div class="stat-item">
                <h3><span id="people-engaged" data-target="1200">0</span>+</h3>
                <p>People Engaged</p>
            </div>
            <div class="stat-item">
                <h3><span id="communities-involved" data-target="300">0</span>+</h3>
                <p>Communities Involved</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Water Conservation Monitor</p>
            <ul class="social-links">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.4.0/justgage.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
