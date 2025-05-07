<?php
session_start();
require 'requires/connect_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Check if the form was submitted and if a file was uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo'])) {
    $logo = $_FILES['logo'];

    // Check for upload errors
    if ($logo['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading file.";
        exit;
    }

    // Check if the file is an image
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($logo['type'], $allowedMimeTypes)) {
        echo "Invalid file type. Please upload a JPEG, PNG, or GIF image.";
        exit;
    }

    // Move the file to the upload directory
    $uploadDir = 'uploads/logos/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($logo['name']);
    $targetFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($logo['tmp_name'], $targetFilePath)) {
        // Update the database with the new logo file path
        $query = "UPDATE users SET company_logo = '$fileName' WHERE id = $userId";
        if (mysqli_query($conn, $query)) {
            echo "Logo uploaded successfully!";
            header("Location: user_account.php");
            exit;
        } else 
        {
            echo "Error updating database: " . mysqli_error($conn);
        }
    } else 
    {
        echo "Error uploading the file.";
    }
}
?>
