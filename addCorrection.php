<?php
// addCorrection.php

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lifewithinus";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to add a new correction request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values
    $billID = $_POST['billID'];
    $requestDetails = $_POST['requestDetails'];
    $status = $_POST['status'];

    // Insert new correction request into the database
    $insertQuery = "INSERT INTO CorrectionRequests (BillID, RequestDetails, Status) 
                    VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iss", $billID, $requestDetails, $status);

    if ($stmt->execute()) {
        // Redirect back to the admin page after adding the correction request
        header("Location: administrator.php");
        exit;
    } else {
        echo "Error adding correction request: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Correction Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            color: #495057;
            background-color: #e2e6ea;
            border-color: #6c757d;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Add New Correction Request</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="billID" class="form-label">Bill ID</label>
                <input type="number" class="form-control" id="billID" name="billID" required>
            </div>
            <div class="mb-3">
                <label for="requestDetails" class="form-label">Request Details</label>
                <textarea class="form-control" id="requestDetails" name="requestDetails" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Request Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Correction Request</button>
            <a href="administrator.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
