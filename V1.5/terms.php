<?php
// Requires the database connection (if needed)
session_start();
require 'requires/connect_db.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sustain Energy - Terms and Conditions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- terms.php -->

<?php include 'requires/nav.php'; ?>

<!-- Terms & Conditions Section -->
<div class="container">
    <h1>Terms and Conditions</h1>
    <p>Welcome to Sustain Energy! By accessing or using our website, you agree to comply with the following terms and conditions:</p>
    
    <h2>1. General Terms</h2>
    <p>These terms and conditions apply to all users of the Sustain Energy website and services. We may update these terms from time to time, and any changes will be posted here.</p>
    
    <h2>2. Use of Services</h2>
    <p>You agree to use our website only for lawful purposes and in a manner that does not infringe the rights of others or restrict their use and enjoyment of the website.</p>
    
    <h2>3. User Responsibilities</h2>
    <ul>
        <li>You are responsible for maintaining the confidentiality of your account information.</li>
        <li>You agree to provide accurate and complete information when registering for any services or products.</li>
        <li>It is your responsibility to comply with local regulations regarding the use of sustainability practices and the purchase of green vouchers.</li>
    </ul>
    
    <h2>4. Prohibited Activities</h2>
    <p>You must not use the site for any illegal activities, including but not limited to:</p>
    <ul>
        <li>Spamming or phishing attempts</li>
        <li>Hacking or attempting unauthorized access to our systems</li>
        <li>Uploading malicious code or viruses</li>
    </ul>

    <h2>5. Privacy and Data Protection</h2>
    <p>Your privacy is important to us. By using our site, you consent to the collection and use of personal information as outlined in our Privacy Policy. We implement security measures to protect your data, but we cannot guarantee 100% security.</p>

    <h2>6. Purchases and Payment</h2>
    <p>When purchasing green vouchers or products, you agree to provide accurate payment information. We accept major credit and debit cards, and all transactions are processed securely.</p>
    
    <h2>7. Termination of Service</h2>
    <p>We reserve the right to suspend or terminate your account if you violate these terms. In case of termination, you will still be liable for any outstanding payments or obligations.</p>
    
    <h2>8. Disclaimers and Limitation of Liability</h2>
    <p>We do not guarantee the availability or accuracy of the content on our site. We are not responsible for any direct or indirect damages that may arise from the use of the site or its services.</p>

    <h2>9. Governing Law</h2>
    <p>These terms and conditions shall be governed by and construed in accordance with the laws of the United Kingdom.</p>

    <h2>10. Contact Information</h2>
    <p>If you have any questions about these terms, please contact us at <a href="mailto:support@sustainenergy.com">support@sustainenergy.com</a>.</p>
    
</div>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

</body>
</html>
