<?php
session_start();
require 'requires/connect_db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sustain Energy - Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
require 'requires/nav.php';

if (isset($_SESSION['company_name'])) {
    echo "<p style='text-align:center; font-weight:bold; margin-top:1em;'>Hello, " . htmlspecialchars($_SESSION['company_name']) . "!</p>";
}
?>

<section class="info">
    <h2>Why Corporate Sustainability Matters</h2>
    <p>
      Sustain Energy is committed to helping businesses measure and improve their environmental impact. 
      Through our <strong>Green Calculator</strong>, companies can track their sustainability efforts, earn recognition with digital certificates (Gold, Silver, Bronze), and purchase Green Vouchers to make up for any shortfall.
    </p>
    <p>
      We promote <strong>Good Corporate Citizenship</strong> by aligning with global goals like those outlined by <a href="https://en.unesco.org/themes/education-sustainable-development" target="_blank">UNESCO</a>. 
      Our goal is to support your journey toward a greener, more responsible future.
    </p>
  </section>

<main class="main-content">
  <section class="hero">
    <h1>Welcome to Sustain Energy</h1>
    <p>Your partner in building a greener future through corporate sustainability.</p>
    <form action="calculator.php" method="get">
      <button type="submit" class="button">Try the Green Calculator</button>
    </form>
  </section>

  <section class="content-grid">
    <div class="card">
      <h2>Green Calculator</h2>
      <p>Evaluate your company’s sustainable practices and earn Green Points to earn better rewards.</p>
      <form action="calculator.php" method="get">
        <button type="submit" class="button">Open Calculator</button>
      </form>
    </div>

    <div class="card">
      <h2>Our Mission</h2>
      <p>What drives us to promote good corporate citizenship and responsibility.</p>
      <form action="about.php" method="get">
        <button type="submit" class="button">Read Mission</button>
      </form>
    </div>

    <div class="card">
      <h2>Sustainability</h2>
      <p>Explore how sustainability works and how to implement it within your business.</p>
      <form action="sustainability.php" method="get">
        <button type="submit" class="button">Learn More</button>
      </form>
    </div>

    <div class="card">
      <h2>Give Feedback</h2>
      <p>Share your thoughts or contact our team. Your opinions are important to us.</p>
      <form action="contact.php" method="get">
        <button type="submit" class="button">Send Feedback</button>
      </form>
    </div>

    <div class="card">
      <h2>Company Dashboard</h2>
      <p>Access your company profile, sustainability status and certificate any time.</p>
      <form action="user_account.php" method="get">
        <button type="submit" class="button">Go to Dashboard</button>
      </form>
    </div>
  </section>


</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
