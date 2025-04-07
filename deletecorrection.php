<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lifewithinus";
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $requestID = $_GET['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM CorrectionRequests WHERE RequestID = ?");
    $stmt->bind_param("i", $requestID); // "i" means the parameter is an integer
    $stmt->execute();

    // Check if the record was deleted successfully
    if ($stmt->affected_rows > 0) {
        // Redirect to the admin dashboard with a success message
        header("Location: administrator.php?message=Correction Request Deleted Successfully");
    } else {
        // Redirect to the admin dashboard with an error message
        header("Location: administrator.php?message=Error Deleting Correction Request");
    }

    $stmt->close();
} else {
    // Redirect to the admin dashboard if no 'id' is provided
    header("Location: administrator.php?message=No RequestID Provided");
}

// Close the database connection
$conn->close();
?>
