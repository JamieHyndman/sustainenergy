<?php
session_start();
require 'requires/connect_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyName = mysqli_real_escape_string($conn, $_POST['company_name']);
    $contactName = mysqli_real_escape_string($conn, $_POST['contact_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $newPassword = $_POST['password'];
    $currentPassword = $_POST['current_password'];

    // Check if current password is correct
    $checkQuery = "SELECT password_hash FROM users WHERE id = $userId";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (!$checkResult || mysqli_num_rows($checkResult) == 0) {
        echo "User not found.";
        exit;
    }

    $userData = mysqli_fetch_assoc($checkResult);
    $hashedPassword = $userData['password_hash'];

    if (!password_verify($currentPassword, $hashedPassword)) {
        echo "Incorrect current password. Please try again.";
        exit;
    }

    // Prepare update query
    $updateQuery = "UPDATE users SET 
        company_name = '$companyName',
        contact_name = '$contactName',
        email = '$email',
        phone = '$phone'";

    // If new password provided, hash and update it
    if (!empty($newPassword)) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery .= ", password_hash = '$newHashedPassword'";
    }

    $updateQuery .= " WHERE id = $userId";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Details updated successfully!";
    } else {
        echo "Error updating details: " . mysqli_error($conn);
    }
    exit;
}

// Fetch current user info for the form
$query = "SELECT company_name, contact_name, email, phone FROM users WHERE id = $userId";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "User not found.";
    exit;
}

$row = mysqli_fetch_assoc($result);
$companyName = $row['company_name'];
$contactName = $row['contact_name'];
$email = $row['email'];
$phone = $row['phone'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Update User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'requires/nav.php'; ?>

    <div class="form-container">
        <h1>Edit Your Details</h1>
        <form action="update_user.php" method="POST" class="form">
    <label for="company_name">Company Name:</label>
    <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($companyName); ?>" required placeholder="Enter company name">

    <label for="contact_name">Contact Name:</label>
    <input type="text" id="contact_name" name="contact_name" value="<?php echo htmlspecialchars($contactName); ?>" required placeholder="Enter your name">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required placeholder="Enter your email">

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" placeholder="Enter phone number">

    <label for="password">New Password (leave blank to keep current):</label>
    <input type="password" id="password" name="password" placeholder="Enter new password">

    <label for="current_password">Current Password (required to update any info):</label>
    <input type="password" id="current_password" name="current_password" required placeholder="Enter current password">

    <button type="submit">Update Details</button>
</form>

    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
