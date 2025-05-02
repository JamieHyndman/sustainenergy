<?php
session_start();
require 'requires/connect_db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sustain Energy - What is Sustainability?</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require 'requires/nav.php'; ?>

<div class="main-content">
    <section class="hero">
        <h1>What is Sustainability?</h1>
        <p style="max-width: 700px; margin: 0 auto;">
            Sustainability means living within the limits of our planet's resources, ensuring that future generations have the same opportunities to thrive as we do today. It’s about balance — environmentally, economically, and socially.
        </p>
    </section>

    <section class="content-grid">
        <div class="card">
            <h2>Our Commitment</h2>
            <p>
                At Sustain Energy, we help businesses and individuals measure and improve their environmental impact through accessible tools, data-driven insights, and community-driven practices.
            </p>
            <ul>
                <li>Monitor your carbon footprint</li>
                <li>Adopt energy-efficient practices</li>
                <li>Reduce waste and source ethically</li>
            </ul>
        </div>

        <div class="card">
            <h2>UNESCO-Aligned Mission</h2>
            <p>
                We align with UNESCOs <strong>Education for Sustainable Development</strong> goals by:
            </p>
            <ul>
                <li>✔ Encouraging environmental awareness</li>
                <li>✔ Promoting responsible business behaviour</li>
                <li>✔ Supporting long-term ecological balance</li>
            </ul>
        </div>

        <div class="card">
            <h2>Why It Matters</h2>
            <p>
                From global warming to plastic pollution, the challenges are vast — but so are the solutions. Sustainability ensures we protect our planet, build resilient communities, and shape a better tomorrow.
            </p>
        </div>
    </section>

    <section class="hero" style="margin-top: 3em;">
        <a href="calculator.php">
            <button>Try Our Green Calculator</button>
        </a>
    </section>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
