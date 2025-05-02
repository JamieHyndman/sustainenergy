<?php
require 'requires/connect_db.php';
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

    $query = "SELECT id, company_name, password_hash FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['company_name'] = $user['company_name'];
            header("Location: index.php"); // Redirect after login
            exit;
        } else {
            $message = "Incorrect password. Try again.";
        }
    } else {
        $message = "No user found with that email. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sustain Energy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'requires/nav.php'; ?>

<main class="form-container">
    <h2>Login</h2>

    <?php if ($message): ?>
        <p class="form-message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" action="login.php" class="form">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
        <button onclick="location.href='register.php'">Want to register? Click Here!</button>
        <button onclick="location.href='forgot_password.php'">Forgot your password? Click Here!</button>
    </form>

</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
