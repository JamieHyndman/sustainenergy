<?php
require 'requires/connect_db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sustain Energy - Privacy Policy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'requires/nav.php'; ?>

<div class="form-container">
    <h1>Privacy Policy</h1>
    <p>At Sustain Energy, we value your trust and are committed to protecting your personal information. This policy outlines how we collect, use, and protect your data when you use our services.</p>

    <div class="question-container active">
        <h2>1. What Information We Collect</h2>
        <ul>
            <li><strong>Account Details:</strong> Name, email, and card information (securely stored).</li>
            <li><strong>Usage Data:</strong> Interactions with our green calculator and shop features.</li>
            <li><strong>Feedback:</strong> Comments and reviews submitted via forms.</li>
        </ul>
    </div>

    <div class="question-container active">
        <h2>2. How We Use Your Data</h2>
        <ul>
            <li>To provide personalised eco-assessments and generate certificates.</li>
            <li>To help you track and improve your sustainability progress.</li>
            <li>To manage purchases and securely process card information.</li>
            <li>To improve our platform through anonymous analytics.</li>
        </ul>
    </div>

    <div class="question-container active">
        <h2>3. Data Storage & Security</h2>
        <ul>
            <li>All sensitive data is encrypted and stored securely.</li>
            <li>We use HTTPS and secure authentication protocols to protect your account.</li>
            <li>Access to user data is strictly limited to necessary staff.</li>
        </ul>
    </div>

    <div class="question-container active">
        <h2>4. Your Rights</h2>
        <ul>
            <li>You can view, edit, or delete your personal data at any time through your profile.</li>
            <li>You can request a full export of your data for transparency.</li>
            <li>You can contact us at <a href="mailto:privacy@sustainenergy.com">privacy@sustainenergy.com</a> for any privacy-related questions.</li>
        </ul>
    </div>

    <div class="question-container active">
        <h2>5. Third Parties</h2>
        <ul>
            <li>We do not sell or share your data with third parties without your explicit consent.</li>
            <li>We use trusted services (like payment processors) with strong privacy policies.</li>
        </ul>
    </div>

    <div class="question-container active">
        <h2>6. Cookies</h2>
        <ul>
            <li>We use minimal cookies to maintain session logins and remember your preferences.</li>
            <li>You can manage cookies via your browser settings.</li>
        </ul>
    </div>

    <div class="question-container active">
        <h2>7. Policy Updates</h2>
        <ul>
            <li>This policy may be updated occasionally to reflect improvements or legal changes.</li>
            <li>Users will be notified of significant changes via email or site notification.</li>
        </ul>
    </div>

    <div class="result">
        <p>Last Updated: April 2025</p>
        <p>For any concerns, email us at <a href="mailto:support@sustainenergy.com">support@sustainenergy.com</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
