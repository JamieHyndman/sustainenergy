<?php
session_start();
require 'requires/connect_db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header('Location: index.php');
    exit;
}

// Approve admin if requested
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_admin_id'])) {
    $approve_id = (int)$_POST['approve_admin_id'];
    $approve_query = "UPDATE users SET is_admin = 1 WHERE id = $approve_id";
    mysqli_query($conn, $approve_query);
}

// Fetch all tables
$users = mysqli_query($conn, "SELECT id, company_name, contact_name, email, phone, join_date, status, is_admin FROM users");
$pending_admins = mysqli_query($conn, "SELECT id, company_name, email FROM users WHERE is_admin = 0");
$feedback = mysqli_query($conn, "SELECT * FROM feedback");
$calculator_results = mysqli_query($conn, "SELECT * FROM calculator_results");
$cards = mysqli_query($conn, "SELECT * FROM cards");
$subscriptions = mysqli_query($conn, "SELECT * FROM subscriptions");
$vouchers = mysqli_query($conn, "SELECT * FROM vouchers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - Sustain Energy</title>
  <link rel="stylesheet" href="style.css">
  <style>

  </style>
</head>
<body>
<?php include 'requires/nav.php'; ?>
<main class="content-container">

  <h1>Admin Dashboard</h1>

  <!-- USERS TABLE -->
  <div class="admin-section">
    <h2>Registered Users</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th><th>Company</th><th>Contact</th><th>Email</th><th>Phone</th><th>Status</th><th>Admin</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($user = mysqli_fetch_assoc($users)): ?>
          <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['company_name']) ?></td>
            <td><?= htmlspecialchars($user['contact_name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['phone']) ?></td>
            <td><?= htmlspecialchars($user['status']) ?></td>
            <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
            <td>
              <?php if (!$user['is_admin']): ?>
                <form method="post" style="display:inline;">
                  <input type="hidden" name="approve_admin_id" value="<?= $user['id'] ?>">
                  <button class="button" type="submit">Approve Admin</button>
                </form>
              <?php endif; ?>
              <form action="delete_user.php" method="POST" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <button class="button danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- FEEDBACK TABLE -->
  <div class="admin-section">
    <h2>User Feedback</h2>
    <table>
      <thead>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Message</th><th>Date</th><th>User ID</th></tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($feedback)): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['message']) ?></td>
            <td><?= $row['submitted_at'] ?></td>
            <td><?= $row['user_id'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- CALCULATOR RESULTS TABLE -->
  <div class="admin-section">
    <h2>Green Calculator Results</h2>
    <table>
      <thead>
        <tr><th>ID</th><th>User ID</th><th>Year</th><th>Score</th><th>Certificate</th><th>Date</th></tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($calculator_results)): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['year'] ?></td>
            <td><?= $row['total_score'] ?></td>
            <td><?= $row['certificate_level'] ?></td>
            <td><?= $row['created_at'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- CARDS TABLE -->
  <div class="admin-section">
    <h2>Registered Payment Cards</h2>
    <table>
      <thead>
        <tr><th>ID</th><th>User ID</th><th>Name</th><th>Card No.</th><th>Expiry</th><th>CVV</th></tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($cards)): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['user_id'] ?></td>
            <td><?= htmlspecialchars($row['cardholder_name']) ?></td>
            <td><?= htmlspecialchars($row['card_number']) ?></td>
            <td><?= htmlspecialchars($row['expiry_date']) ?></td>
            <td><?= htmlspecialchars($row['cvv']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- SUBSCRIPTIONS TABLE -->
  <div class="admin-section">
    <h2>User Subscriptions</h2>
    <table>
      <thead>
        <tr><th>ID</th><th>User ID</th><th>Start</th><th>End</th><th>Price</th><th>Status</th></tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($subscriptions)): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['start_date'] ?></td>
            <td><?= $row['end_date'] ?></td>
            <td>£<?= $row['price'] ?></td>
            <td><?= $row['status'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- VOUCHERS TABLE -->
  <div class="admin-section">
    <h2>Voucher Purchases</h2>
    <table>
      <thead>
        <tr><th>ID</th><th>User ID</th><th>Year</th><th>Points</th><th>Paid (£)</th><th>Date</th></tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($vouchers)): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['year'] ?></td>
            <td><?= $row['points_purchased'] ?></td>
            <td>£<?= $row['amount_paid'] ?></td>
            <td><?= $row['created_at'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</main>
<?php include 'includes/footer.php'; ?>
</body>
</html>
