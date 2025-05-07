<?php
session_start();
require 'requires/connect_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sustain Energy - Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require 'requires/nav.php'; ?>

<div class="form-container">
    <h1>Contact Us</h1>

    <?php
    $successMessage = '';
    $errorMessage = '';
    $user_id = $_SESSION['user_id']; // Retrieve logged-in user's ID

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require 'requires/connect_db.php';

        // Sanitize input
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $phone = htmlspecialchars(trim($_POST['phone']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Server-side validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Please enter a valid email address.";
        } elseif (!empty($phone) && !preg_match('/^\d+$/', $phone)) {
            $errorMessage = "Phone number should contain only numbers.";
        } elseif (empty($name) || empty($message)) {
            $errorMessage = "Name and message fields are required.";
        } else {
            // Insert into DB
            $query = "INSERT INTO feedback (name, email, phone, message, user_id) 
                      VALUES ('$name', '$email', '$phone', '$message', '$user_id')";

            if (mysqli_query($conn, $query)) {
                $successMessage = "Message sent successfully!";
            } else {
                $errorMessage = "Error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        }
    }
    ?>

    <?php if ($successMessage): ?>
        <div class="form-message" style="background:#e7ffe7; border-left:5px solid #a8e994;">
            <?= $successMessage ?>
        </div>
    <?php elseif ($errorMessage): ?>
        <div class="form-message" style="background:#ffe7e7; border-left:5px solid #e99494;">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" class="form" novalidate>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" pattern="\d*" title="Numbers only" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">

    <label for="message">Message:</label>
    <textarea id="message" name="message" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>

    <button type="submit" name="submit">Send</button>
</form>

</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
