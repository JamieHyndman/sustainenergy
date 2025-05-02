
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<?php 
// Start the session to track user
session_start();
require 'requires/connect_db.php';
require 'requires/nav.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Retrieve logged-in user's ID

// Step 1: Check if user has a card associated with their account
$sql_check_card = "SELECT id FROM cards WHERE user_id = ?";
$query = $conn->prepare($sql_check_card);
$query->bind_param("i", $user_id);
$query->execute();
$query->store_result();

// If no card is found, deny access
if ($query->num_rows == 0) {
    echo "You must have a card associated with your account to subscribe.";
    exit();
}

// Step 2: Check if user has already subscribed within the last 12 months
$sql_check_subscription = "SELECT id FROM subscriptions WHERE user_id = ? AND start_date > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
$query = $conn->prepare($sql_check_subscription);
$query->bind_param("i", $user_id);
$query->execute();
$query->store_result();

// If a subscription exists within the last 12 months, deny access
if ($query->num_rows > 0) {
    echo "You have already subscribed within the last year. You can subscribe again after a year from your last subscription.";
    exit();
}

// Define the price here to avoid undefined variable error
$price = 99.00; // Example price for subscription, change as needed
$status = 'active'; // Example status, you may want to add more logic here

// Step 3: Handle subscription if a card is associated and no subscription within the last year
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Step 4: Insert subscription details into the database
    $sql_insert_subscription = "INSERT INTO subscriptions (user_id, start_date, price, status) VALUES (?, CURDATE(), ?, ?)";
    $query = $conn->prepare($sql_insert_subscription);
    $query->bind_param("ids", $user_id, $price, $status);
    
    if ($query->execute()) {
        echo "Subscription successfully activated!";
    } else {
        echo "An error occurred. Please try again later.";
    }
}

// Step 5: Display the subscription form
?>-


    <h1>Subscribe to Our Service</h1>
    <form method="POST">
        <label for="price">Subscription Price: £<?php echo $price; ?></label><br><br>
        <button type="submit">Subscribe Now</button>
    </form>
    <?php include 'includes/footer.php'; ?>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
