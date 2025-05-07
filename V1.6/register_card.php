<?php
session_start();
require 'requires/connect_db.php';

$error_message = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardNumber = $_POST['card_number'];
    $expiryDate = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $cardholderName = $_POST['cardholder_name'];
    $userId = $_SESSION['user_id'];

    // Basic server-side validation
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
        $checkQuery = "SELECT id FROM cards WHERE user_id = $userId";
        $checkResult = mysqli_query($conn, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            $updateQuery = "UPDATE cards SET cardholder_name='$cardholderName', card_number='$cardNumber', expiry_date='$expiryDate', cvv='$cvv' WHERE user_id=$userId";
            mysqli_query($conn, $updateQuery);
        } else {
            $insertQuery = "INSERT INTO cards (user_id, cardholder_name, card_number, expiry_date, cvv) VALUES ($userId, '$cardholderName', '$cardNumber', '$expiryDate', '$cvv')";
            mysqli_query($conn, $insertQuery);
        }

        header("Location: user_account.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Card</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'requires/nav.php'; ?>

<div class="form-container">
    <h1>Register Your Card</h1>
    
    <!-- Display error message if it exists -->
    <?php if ($error_message): ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($error_message); ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="form">
        <label for="cardholder_name">Cardholder Name:</label>
        <input type="text" name="cardholder_name" id="cardholder_name" required>

        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number" id="card_number" maxlength="16" pattern="\d{16}" title="Enter exactly 16 digits" required>

        <label for="expiry_date">Expiry Date (MM/YY):</label>
        <input type="text" name="expiry_date" id="expiry_date" pattern="^(0[1-9]|1[0-2])\/\d{2}$" title="Format: MM/YY" required>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" id="cvv" maxlength="3" pattern="\d{3}" title="Enter exactly 3 digits" required>

        <button type="submit">Save Card</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
