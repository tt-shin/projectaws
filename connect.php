<?php
$servername = "";
$username = "admin";
$password = "awsprojectdb";
$dbname = "projectaws";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
