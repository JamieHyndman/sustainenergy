<?php

require 'requires/connect_db.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect input
    $company = mysqli_real_escape_string($conn, $_POST["company_name"]);
    $contact = mysqli_real_escape_string($conn, $_POST["contact_name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"]; // Raw for hashing
    $phone_number = mysqli_real_escape_string($conn, $_POST["phone_number"]);

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_query = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $message = "Email already registered. Please try another email address.";
    } else {
        // Insert user
        $insert_query = "INSERT INTO users (company_name, contact_name, email, password_hash, phone)
                         VALUES ('$company', '$contact', '$email', '$password_hash', '$phone_number')";

        if (mysqli_query($conn, $insert_query)) {
            $message = "Registration successful! You can now <a href='login.php'>login</a>.";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sustain Energy</title>
    <link rel="stylesheet" href="style.css">
  
</head>
<body>
<?php include 'requires/nav.php'; ?>

<main class="form-container">
    <h2>Register Your Company</h2>
    
    <?php if ($message): ?>
        <p class="form-message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" action="register.php" class="form">
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required placeholder="Enter your company name">
       
        <label for="contact_name">Contact Name:</label>
        <input type="text" id="contact_name" name="contact_name" required placeholder="Enter your contact name">
        
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required placeholder="Enter your Email">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required placeholder="*************">

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required placeholder="Enter your phone number">

        <button type="submit">Register</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
