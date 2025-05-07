<?php
require 'requires/connect_db.php';
session_start();



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Sustain Energy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require 'requires/nav.php'; ?>

<div class="container">
    <h1>About Sustain Energy</h1>

    <section class="question-container active">
        <h2>Our Mission</h2>
        <p>At Sustain Energy, our mission is to empower businesses with tools to understand, improve, and celebrate their sustainability journey.</p>
        <p>We believe in accessible education, transparent accountability, and a greener future for all. Through our Green Calculator and certification system, we aim to make environmental responsibility practical, rewarding, and achievable.</p>
    </section>

    <section class="question-container active">
        <h2>Our Story</h2>
        <p>Sustain Energy was founded by a team of passionate developers, environmentalists, and educators. We recognised a gap in how sustainability data is presented and wanted to bridge it with clarity and creativity.</p>
        <p>Since our launch, we've helped small businesses and eco-conscious individuals across the UK measure and improve their environmental footprint.</p>
    </section>

    <section class="question-container active">
        <h2>Our Values</h2>
        <ul>
            <li><strong>Accessibility:</strong> Making green tools available to everyone, no matter the size of their organisation.</li>
            <li><strong>Transparency:</strong> Providing clear and honest metrics, grading, and feedback on sustainability performance.</li>
            <li><strong>Community:</strong> Supporting a growing network of like-minded users, sharing tips, knowledge, and green initiatives.</li>
        </ul>
    </section>

    <section class="question-container active">
        <h2>What We Offer</h2>
        <p>We provide:</p>
        <ul>
            <li>A dynamic Green Calculator tailored to common business practices</li>
            <li>Printable Sustainability Certificates (Bronze, Silver, and Gold)</li>
            <li>A donation shop where you can contribute toward eco-projects and earn points</li>
            <li>Account features to track progress and maintain history of results</li>
        </ul>
    </section>

    <section class="question-container active">
        <h2>Join Us on the Journey</h2>
        <p>Whether you're a business owner, student, or someone passionate about the planet — you're welcome here. Create an account today and take your first step toward a more sustainable future!</p>
        <p style="text-align:center;">
            <a href="register.php"><button>Get Started</button></a>
        </p>
    </section>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
