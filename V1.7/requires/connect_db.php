<?php
$servername = "localhost";
$username = "EC2248699";
$password = "GradedUnit2"; 
$dbname = "sustainenergydb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
