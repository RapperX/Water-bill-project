<?php
// db.php - Database connection file

$servername = "localhost";  // Database server (usually localhost)
$username = "root";         // Database username
$password = "";             // Database password (empty if no password)
$dbname = "lifewithinus";     // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
