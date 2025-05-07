<?php
require 'requires/connect_db.php';
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

    $query = "SELECT id, company_name, password_hash, is_admin FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['company_name'] = $user['company_name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: index.php");
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

    <form method="post" action="login.php" class="form" autocomplete="on">
    <label for="email">Email:</label>
    <input 
        type="email" 
        id="email" 
        name="email" 
        required 
        placeholder="Enter your email" 
        title="Enter your email address" 
        autocomplete="email"
    >

    <label for="password">Password:</label>
    <input 
        type="password" 
        id="password" 
        name="password" 
        required 
        placeholder="Enter your password" 
        title="Enter your password" 
        autocomplete="current-password"
    >

    <button type="submit">Login</button>

    <button type="button" onclick="location.href='register.php'">Want to register? Click Here!</button>
    <button type="button" onclick="location.href='forgot_password.php'">Forgot your password? Click Here!</button>
</form>


</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
