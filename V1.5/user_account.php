<?php
session_start();
require 'requires/connect_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$query = "SELECT company_name, contact_name, email, phone, company_logo FROM users WHERE id = $userId";
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
$companyLogo = $row['company_logo'];

// Fetch previous calculator scores
$scoresQuery = "SELECT year, total_score, certificate_level FROM calculator_results WHERE user_id = $userId ORDER BY year DESC";
$scoresResult = mysqli_query($conn, $scoresQuery);

// Fetch previous voucher purchases
$vouchersQuery = "SELECT year, points_purchased, amount_paid, created_at FROM vouchers WHERE user_id = $userId ORDER BY created_at DESC";
$vouchersResult = mysqli_query($conn, $vouchersQuery);

$cardQuery = "SELECT cardholder_name, card_number, expiry_date FROM cards WHERE user_id = $userId LIMIT 1";
$cardResult = mysqli_query($conn, $cardQuery);

$cardholderName = "Not available";
$cardLast4 = "Not available";
$expiryDate = "Not available";

if ($cardResult && mysqli_num_rows($cardResult) > 0) {
    $cardRow = mysqli_fetch_assoc($cardResult);
    $cardholderName = htmlspecialchars($cardRow['cardholder_name']);
    $cardNumber = $cardRow['card_number'];
    $expiryDate = htmlspecialchars($cardRow['expiry_date']);

    if (strlen($cardNumber) >= 4) {
        $cardLast4 = substr($cardNumber, -4);
    }
}

$subscriptionQuery = "SELECT start_date, end_date, price, status FROM subscriptions WHERE user_id = $userId ORDER BY start_date DESC LIMIT 1";
$subscriptionResult = mysqli_query($conn, $subscriptionQuery);

$subscription = null;
if ($subscriptionResult && mysqli_num_rows($subscriptionResult) > 0) {
    $subscription = mysqli_fetch_assoc($subscriptionResult);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'requires/nav.php'; ?>

<div class="form-container">
    <h1>Welcome, <?php echo htmlspecialchars($contactName); ?>!</h1>

    <h2>Your Details</h2>
    <p><strong>Company Name:</strong> <?php echo htmlspecialchars($companyName); ?></p>
    <p><strong>Contact Name:</strong> <?php echo htmlspecialchars($contactName); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>

    <?php if ($companyLogo): ?>
        <p><strong>Company Logo:</strong><br>
            <img src="uploads/logos/<?php echo htmlspecialchars($companyLogo); ?>" alt="Company Logo" height="100">
        </p>
    <?php else: ?>
        <p><strong>Company Logo:</strong> Not uploaded yet.</p>
    <?php endif; ?>

    <p><a href="update_user.php">Edit your details</a></p>
</div>

<div class="form-container">
    <h2>Your Card Information</h2>
    <?php if ($cardLast4 === "Not available"): ?>
        <button onclick="window.location.href='register_card.php';">Register a new card</button>
    <?php else: ?>
        <p><strong>Cardholder Name:</strong> <?php echo $cardholderName; ?></p>
        <p><strong>Card (last 4 digits):</strong> <?php echo $cardLast4; ?></p>
        <p><strong>Expiry Date:</strong> <?php echo $expiryDate; ?></p>
        <button onclick="window.location.href='manage_card.php';">Manage Your Card</button>
    <?php endif; ?>
</div>

<div class="form-container">
    <h2>Upload Your Company Logo</h2>
    <form action="upload_logo.php" method="POST" enctype="multipart/form-data" class="form">
    <label for="logo">Choose a logo to upload:</label>
    <input id="logo" type="file" name="logo" accept="image/*" title="Upload your company logo">
        <button type="submit">Upload Logo</button>
    </form>
</div>

<div class="form-container">
    <h2>Your Previous Green Scores</h2>
    <?php if ($scoresResult && mysqli_num_rows($scoresResult) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Score</th>
                    <th>Certificate</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($score = mysqli_fetch_assoc($scoresResult)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($score['year']); ?></td>
                        <td><?php echo htmlspecialchars($score['total_score']); ?>/100</td>
                        <td>
                            <?php echo htmlspecialchars($score['certificate_level']); ?>
                            <form action="generate_certificate.php" method="get" style="display:inline;">
                                <input type="hidden" name="score" value="<?php echo htmlspecialchars($score['total_score']); ?>">
                                <input type="hidden" name="level" value="<?php echo htmlspecialchars($score['certificate_level']); ?>">
                                <input type="hidden" name="year" value="<?php echo htmlspecialchars($score['year']); ?>">
                                <button type="submit">Generate</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No previous scores found.</p>
    <?php endif; ?>
</div>

<div class="form-container">
    <h2>Your Voucher Purchases</h2>
    <?php if ($vouchersResult && mysqli_num_rows($vouchersResult) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Points Purchased</th>
                    <th>Amount Paid (£)</th>
                    <th>Purchased On</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($voucher = mysqli_fetch_assoc($vouchersResult)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($voucher['year']); ?></td>
                        <td><?php echo htmlspecialchars($voucher['points_purchased']); ?></td>
                        <td><?php echo number_format($voucher['amount_paid'], 2); ?></td>
                        <td><?php echo date('j M Y', strtotime($voucher['created_at'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No voucher purchases found.</p>
    <?php endif; ?>
</div>

<div class="form-container">
    <h2>Your Subscription</h2>
    <?php if ($subscription): ?>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($subscription['status']); ?></p>
        <p><strong>Start Date:</strong> <?php echo date('j M Y', strtotime($subscription['start_date'])); ?></p>
        <p><strong>End Date:</strong> 
            <?php 
                echo $subscription['end_date'] ? date('j M Y', strtotime($subscription['end_date'])) : 'Ongoing'; 
            ?>
        </p>
        <p><strong>Price:</strong> £<?php echo number_format($subscription['price'], 2); ?></p>
    <?php else: ?>
        <p>You are not currently subscribed.</p>
    <?php endif; ?>
</div>



<?php include 'includes/footer.php'; ?>
</body>
</html>
