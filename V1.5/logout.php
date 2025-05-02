<?php
session_start();
session_unset();   // Clear all session variables
session_destroy(); // End the session

// Redirect back to home page
header("Location: index.php");
exit;