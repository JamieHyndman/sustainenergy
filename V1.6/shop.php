<?php
session_start();
require 'requires/connect_db.php';
require 'requires/nav.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$year = date("Y");
$error = "";
$success = "";
$updated_score = null;
$updated_level = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase'])) {
    $points_needed = (int)$_POST['points_needed'];
    $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);

    // Error handling: Ensure the form fields are not empty
    if (empty($card_number) || empty($expiry_date) || empty($cvv)) {
        $error = "All fields must be filled out.";
    } elseif (!preg_match("/^\d{16}$/", $card_number)) {
        $error = "Invalid card number. Please enter 16 digits.";
    } elseif (!preg_match("/^(0[1-9]|1[0-2])\/\d{2}$/", $expiry_date)) {
        $error = "Invalid expiry date. Please enter in MM/YY format.";
    } elseif (!preg_match("/^\d{3}$/", $cvv)) {
        $error = "Invalid CVV. Please enter 3 digits.";
    } else {
        // Error handling: Check for card details in the database
        $query = "SELECT * FROM cards WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            $error = "Database error: Unable to fetch card details.";
        } elseif ($row = mysqli_fetch_assoc($result)) {
            if (
                $row['card_number'] === $card_number &&
                $row['expiry_date'] === $expiry_date &&
                $row['cvv'] === $cvv
            ) {
                // Error handling: Fetch the score data
                $score_result = mysqli_query($conn, "SELECT total_score FROM calculator_results WHERE user_id = '$user_id' AND year = '$year' ORDER BY id DESC LIMIT 1");
                if (!$score_result) {
                    $error = "Database error: Unable to fetch score details.";
                } else {
                    $score_row = mysqli_fetch_assoc($score_result);
                    $current_score = $score_row ? (int)$score_row['total_score'] : 0;

                    $new_score = min($current_score + $points_needed, 100);

                    if ($new_score >= 70) {
                        $new_level = 'Gold';
                    } elseif ($new_score >= 60) {
                        $new_level = 'Silver';
                    } else {
                        $new_level = 'Bronze';
                    }

                    // Error handling: Update the database with the new score
                    if (!mysqli_query($conn, "UPDATE calculator_results SET total_score = '$new_score', certificate_level = '$new_level' WHERE user_id = '$user_id' AND year = '$year'")) {
                        $error = "Database error: Unable to update score.";
                    } else {
                        $amount_paid = $points_needed * 10;
                        // Error handling: Insert voucher purchase into the database
                        if (!mysqli_query($conn, "INSERT INTO vouchers (user_id, year, points_purchased, amount_paid) VALUES ('$user_id', '$year', '$points_needed', '$amount_paid')")) {
                            $error = "Database error: Unable to record voucher purchase.";
                        } else {
                            $success = "Thank you for your purchase! Your updated certificate is ready.";
                            $updated_score = $new_score;
                            $updated_level = $new_level;
                        }
                    }
                }
            } else {
                $error = "Card details do not match our records.";
            }
        } else {
            $error = "No card is registered to your account.";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['points_needed'])) {
    $points_needed = (int)$_POST['points_needed'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Voucher Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main-content">
    <h1>Purchase Green Vouchers</h1>

    <?php if ($success): ?>
        <div class="result">
            <p><?= $success ?></p>
            <a href="generate_certificate.php?score=<?= $updated_score ?>&level=<?= $updated_level ?>" class="button" target="_blank">Download Updated Certificate</a>
        </div>
    <?php elseif (isset($points_needed)): ?>
        <div class="form-container">
            <form method="POST" action="shop.php" class="form">
                <input type="hidden" name="points_needed" value="<?= $points_needed ?>">
                <h2>Confirm Payment</h2>
                <p>You are about to pay <strong>£<?= $points_needed * 10 ?></strong> for <strong><?= $points_needed ?> point<?= $points_needed > 1 ? 's' : '' ?></strong></p>

                <?php if ($error): ?>
                    <div class="form-message" style="background: #ffe7e7; border-left: 5px solid #e99494;">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <label for="card_number">Card Number (16 digits):</label>
                <input type="text" name="card_number" id="card_number" pattern="\d{16}" maxlength="16" required>

                <label for="expiry_date">Expiry Date (MM/YY):</label>
                <input type="text" name="expiry_date" id="expiry_date" pattern="(0[1-9]|1[0-2])\/\d{2}" required>

                <label for="cvv">CVV (3 digits):</label>
                <input type="text" name="cvv" id="cvv" pattern="\d{3}" maxlength="3" required>

                <button type="submit" name="confirm_purchase">Submit</button>
            </form>
        </div>
    <?php else: ?>
        <p style="text-align: center;">No voucher selected. Return to <a href="calculator.php">Green Calculator</a>.</p>
    <?php endif; ?>
</div>
</body>
</html>
