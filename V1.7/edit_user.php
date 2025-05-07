<?php
session_start();
require 'requires/connect_db.php';

// Restrict access to admin users
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: view_users.php");
    exit;
}

$user_id = (int) $_GET['id'];
$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_name = mysqli_real_escape_string($conn, $_POST['contact_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Update user info
    $update_query = "
        UPDATE users SET 
            company_name = '$company_name',
            email = '$email',
            contact_name = '$contact_name',
            phone = '$phone',
            is_admin = $is_admin
        WHERE id = $user_id
    ";

    if (mysqli_query($conn, $update_query)) {
        $success_message = "User details updated successfully.";
    } else {
        $error_message = "Error updating user: " . mysqli_error($conn);
    }
}

// Fetch user details
$query = "SELECT id, company_name, email, contact_name, phone, is_admin FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<?php include 'requires/nav.php'; ?>

<main class="form-container">
    <h2>Edit User - <?php echo htmlspecialchars($user['company_name']); ?></h2>

    <?php if ($success_message): ?>
        <p class="form-success"><?php echo $success_message; ?></p>
    <?php elseif ($error_message): ?>
        <p class="form-error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post" action="">
    <label for="company_name">Company Name:</label>
    <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($user['company_name']); ?>" required placeholder="Enter company name">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required placeholder="Enter email address">

    <label for="contact_name">Contact Name:</label>
    <input type="text" id="contact_name" name="contact_name" value="<?php echo htmlspecialchars($user['contact_name']); ?>" placeholder="Enter contact name">

    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" placeholder="Enter phone number">

    <label for="is_admin">
        <input type="checkbox" id="is_admin" name="is_admin" <?php if ($user['is_admin']) echo 'checked'; ?>>
        Administrator
    </label>

    <button type="submit">Update User</button>
    <a href="view_users.php" class="button">Back to User List</a>
</form>

</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
