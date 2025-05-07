<?php
session_start();
require 'requires/connect_db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = (int) $_POST['user_id'];

    // Optional: prevent admin from deleting themselves
    if ($_SESSION['user_id'] == $user_id) {
        header("Location: view_users.php?error=selfdelete");
        exit;
    }

    $query = "DELETE FROM users WHERE id = $user_id";
    mysqli_query($conn, $query);
}

header("Location: view_users.php");
exit;
