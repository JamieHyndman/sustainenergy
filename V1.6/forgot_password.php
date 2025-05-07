<?php
require 'requires/connect_db.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if email exists
    $business_id = mysqli_real_escape_string($conn, $_POST['business_id']);
    $check_query = "SELECT id FROM users WHERE email = '$email' AND business_id = '$business_id'";
    
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) === 1) {
        if ($new_password === $confirm_password) {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET password_hash = '$hashed' WHERE email = '$email'";
            if (mysqli_query($conn, $update_query)) {
                $message = "Password successfully updated. You can now <a href='login.php'>log in</a>.";
            } else {
                $message = "Failed to update password. Please try again.";
            }
        } else {
            $message = "Passwords do not match.";
        }
    } else {
        $message = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Sustain Energy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'requires/nav.php'; ?>

<main class="form-container">
    <h2>Forgot Password</h2>

    <?php if ($message): ?>
        <p class="form-message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" class="form">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>

        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required>

        <label>Business ID:</label>
        <input type="text" name="business_id" required>

        <button type="submit">Reset Password</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
