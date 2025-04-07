<?php
// addBill.php

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lifewithinus";
$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to add a new water bill
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values
    $customerID = $_POST['customerID'];
    $date = $_POST['date'];
    $waterConsumption = $_POST['waterConsumption'];
    $amountDue = $_POST['amountDue'];
    $status = $_POST['status'];

    // Insert new water bill into the database
    $insertQuery = "INSERT INTO WaterBills (CustomerID, Date, WaterConsumption, AmountDue, Status) 
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("issds", $customerID, $date, $waterConsumption, $amountDue, $status);

    if ($stmt->execute()) {
        // Redirect back to the admin page after adding the bill
        header("Location: admin.php");
        exit;
    } else {
        echo "Error adding water bill: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Water Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Add New Water Bill</h1>
        <form method="POST">
            <!-- Customer ID Input -->
            <div class="mb-3">
                <label for="customerID" class="form-label">Customer ID</label>
                <input type="number" class="form-control" id="customerID" name="customerID" required>
            </div>
            
            <!-- Date Input -->
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            
            <!-- Water Consumption Input -->
            <div class="mb-3">
                <label for="waterConsumption" class="form-label">Water Consumption (m³)</label>
                <input type="number" class="form-control" id="waterConsumption" name="waterConsumption" step="0.01" required>
            </div>
            
            <!-- Amount Due Input -->
            <div class="mb-3">
                <label for="amountDue" class="form-label">Amount Due</label>
                <input type="number" class="form-control" id="amountDue" name="amountDue" step="0.01" required>
            </div>
            
            <!-- Status Select -->
            <div class="mb-3">
                <label for="status" class="form-label">Bill Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Unpaid">Unpaid</option>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
            
            <!-- Submit and Cancel Buttons -->
            <button type="submit" class="btn btn-primary">Add Water Bill</button>
            <a href="admin.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
