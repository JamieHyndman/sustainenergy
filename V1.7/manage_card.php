<?php
session_start();
require 'requires/connect_db.php';

$error_message = '';
$success_message = '';
$cardDetails = null;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch card details
$cardQuery = "SELECT * FROM cards WHERE user_id = $userId";
$cardResult = mysqli_query($conn, $cardQuery);

if ($cardResult && mysqli_num_rows($cardResult) > 0) {
    $cardDetails = mysqli_fetch_assoc($cardResult);
} else {
    header("Location: user_account.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $cardNumber = $_POST['card_number'];
    $expiryDate = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $cardholderName = $_POST['cardholder_name'];

    // Check password
    $userQuery = "SELECT password_hash FROM users WHERE id = $userId";
    $userResult = mysqli_query($conn, $userQuery);
    $user = mysqli_fetch_assoc($userResult);

    if (!$user || !password_verify($password, $user['password_hash'])) {
        $error_message = "Incorrect password. Please try again.";
    } else {
        // Validate inputs
        if (!preg_match('/^\d{16}$/', $cardNumber)) {
            $error_message = "Card number must be exactly 16 digits.";
        } elseif (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiryDate)) {
            $error_message = "Expiry date must be in MM/YY format.";
        } else {
            $expiryParts = explode('/', $expiryDate);
            $expiryMonth = (int)$expiryParts[0];
            $expiryYear = (int)$expiryParts[1] + 2000;

            $currentYear = (int)date("Y");
            $currentMonth = (int)date("m");

            if ($expiryYear < $currentYear || ($expiryYear == $currentYear && $expiryMonth < $currentMonth)) {
                $error_message = "Expiry date must be in the future.";
            }
        }

        if (!preg_match('/^\d{3}$/', $cvv)) {
            $error_message = "CVV must be exactly 3 digits.";
        }

        if ($error_message === '') {
            $updateQuery = "UPDATE cards 
                            SET cardholder_name = '$cardholderName',
                                card_number = '$cardNumber',
                                expiry_date = '$expiryDate',
                                cvv = '$cvv'
                            WHERE user_id = $userId";

            if (mysqli_query($conn, $updateQuery)) {
                $success_message = "Card details updated successfully.";
                // Refresh card details
                $cardResult = mysqli_query($conn, $cardQuery);
                $cardDetails = mysqli_fetch_assoc($cardResult);
            } else {
                $error_message = "Failed to update card. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Card</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'requires/nav.php'; ?>

<div class="form-container">        
    <h1>Manage Your Card</h1>

    <?php if ($error_message): ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($error_message); ?></p>
        </div>
    <?php elseif ($success_message): ?>
        <div class="success-message">
            <p><?php echo htmlspecialchars($success_message); ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="form">
        <label for="cardholder_name">Cardholder Name:</label>
        <input type="text" name="cardholder_name" id="cardholder_name" value="<?php echo htmlspecialchars($cardDetails['cardholder_name']); ?>" required>

        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number" id="card_number" maxlength="16" pattern="\d{16}" title="Enter exactly 16 digits" value="<?php echo htmlspecialchars($cardDetails['card_number']); ?>" required>

        <label for="expiry_date">Expiry Date (MM/YY):</label>
        <input type="text" name="expiry_date" id="expiry_date" pattern="^(0[1-9]|1[0-2])\/\d{2}$" title="Format: MM/YY" value="<?php echo htmlspecialchars($cardDetails['expiry_date']); ?>" required>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" id="cvv" maxlength="3" pattern="\d{3}" title="Enter exactly 3 digits" value="<?php echo htmlspecialchars($cardDetails['cvv']); ?>" required>

        <label for="password">Confirm Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Update Card</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
