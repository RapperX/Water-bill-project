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

    // Fetch the correction request from the database
    $stmt = $conn->prepare("SELECT * FROM CorrectionRequests WHERE RequestID = ?");
    $stmt->bind_param("i", $requestID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Correction request not found.";
        exit;
    }

    $stmt->close();
}

// Check if the form is submitted to update the correction request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestDetails = $_POST['requestDetails'];
    $status = $_POST['status'];

    // Update the correction request in the database
    $stmt = $conn->prepare("UPDATE CorrectionRequests SET RequestDetails = ?, Status = ? WHERE RequestID = ?");
    $stmt->bind_param("ssi", $requestDetails, $status, $requestID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: administrator.php?message=Correction Request Updated Successfully");
    } else {
        echo "Error updating correction request.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Correction Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Correction Request</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="requestDetails" class="form-label">Request Details</label>
                <textarea id="requestDetails" name="requestDetails" class="form-control" required><?php echo $row['RequestDetails']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="Pending" <?php if ($row['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Resolved" <?php if ($row['Status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                    <option value="Rejected" <?php if ($row['Status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update Correction Request</button>
        </form>
        <a href="administrator.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
