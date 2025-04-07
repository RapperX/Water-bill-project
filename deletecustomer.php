<?php
// deleteCustomer.php
// Delete a customer from the database based on the provided ID

// deleteCustomer.php

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lifewithinus";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' parameter is set (the customer ID)
if (isset($_GET['id'])) {
    $customerID = $_GET['id'];

    // First, check if the customer exists before trying to delete
    $checkQuery = "SELECT * FROM Customers WHERE CustomerID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the customer exists, proceed to delete
    if ($result->num_rows == 1) {
        // Delete the customer from the database
        $deleteQuery = "DELETE FROM Customers WHERE CustomerID = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $customerID);

        if ($stmt->execute()) {
            // Redirect back to the admin page after deletion
            header("Location: administrator.php");
            exit;
        } else {
            echo "Error deleting customer: " . $conn->error;
        }
    } else {
        echo "Customer not found!";
        exit;
    }
} else {
    echo "Invalid customer ID!";
    exit;
}

$conn->close();
?>


