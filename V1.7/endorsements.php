<?php
// Requires the database connection (if needed)
session_start();
require 'requires/connect_db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sustain Energy - Endorsements</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 1000px;
            margin: 2em auto;
            padding: 1em;
        }

        .logo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2em;
            margin-top: 2em;
        }

        .logo-card {
            background: #f2fef5;
            border: 1px solid #cdebdc;
            padding: 1em;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        .logo-card img {
            max-width: 120px;
            height: auto;
            margin-bottom: 1em;
        }

        .logo-card h3 {
            color: #17994c;
            font-size: 1.2em;
            margin-bottom: 0.5em;
        }

        .logo-card p {
            font-size: 0.95em;
            color: #2b463c;
        }
    </style>
</head>
<body>

<?php require 'requires/nav.php'; ?>

<div class="container">
    <h1>Endorsements & Partners</h1>
    <p>Sustain Energy is proud to be supported by a diverse network of partners dedicated to a greener future. These organisations play a key role in empowering our mission through innovation, education, and environmental action.</p>

    <div class="logo-grid">
        <div class="logo-card">
            <img src="images/Eco_Alliance.png" alt="Eco Alliance">
            <h3>Eco Alliance</h3>
            <p>UK-wide environmental lobbyists helping to push eco policy into mainstream practice since 2009.</p>
        </div>
        <div class="logo-card">
            <img src="images/Green_Scotland.png" alt="Green Scotland">
            <h3>Green Scotland</h3>
            <p>Scotland's top clean energy initiative. Backers of green infrastructure for over 100 communities.</p>
        </div>
        <div class="logo-card">
            <img src="images/UNESCO.png" alt="UNESCO ESD">
            <h3>UNESCO ESD</h3>
            <p>We work closely with the Education for Sustainable Development initiative to promote climate literacy in schools.</p>
        </div>
        <div class="logo-card">
            <img src="images/Clean_Tech.png" alt="CleanTech Futures">
            <h3>CleanTech Futures</h3>
            <p>A startup accelerator supporting low-emission technologies, responsible for launching over 50 eco products.</p>
        </div>
        <div class="logo-card">
            <img src="images/Tree_Trust.png" alt="TreeTrust UK">
            <h3>TreeTrust UK</h3>
            <p>National reforestation charity planting over 1 million trees per year. Proud partners in our carbon offset efforts.</p>
        </div>
        <div class="logo-card">
            <img src="images/Youth_Go_Green.png" alt="Youth for Green">
            <h3>Youth for Green</h3>
            <p>A youth-led movement encouraging climate activism and sustainability leadership among young people.</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
