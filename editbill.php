<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lifewithinus";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' parameter is passed in the URL
if (isset($_GET['id'])) {
    $billID = $_GET['id'];

    // Fetch the bill data for the specific BillID
    $stmt = $conn->prepare("SELECT * FROM WaterBills WHERE BillID = ?");
    $stmt->bind_param("i", $billID); // 'i' indicates integer type
    $stmt->execute();
    $result = $stmt->get_result();
    $bill = $result->fetch_assoc();

    // If the bill does not exist
    if (!$bill) {
        die("Bill not found.");
    }
} else {
    die("Bill ID not provided.");
}

// Handle form submission for updating the bill
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerID = $_POST['CustomerID'];
    $date = $_POST['Date'];
    $waterConsumption = $_POST['WaterConsumption'];
    $amountDue = $_POST['AmountDue'];
    $status = $_POST['Status'];

    // Update the bill record in the database
    $stmt = $conn->prepare("UPDATE WaterBills SET CustomerID = ?, Date = ?, WaterConsumption = ?, AmountDue = ?, Status = ? WHERE BillID = ?");
    $stmt->bind_param("issdsi", $customerID, $date, $waterConsumption, $amountDue, $status, $billID); // 's' is for string, 'd' for double, 'i' for integer
    if ($stmt->execute()) {
        // Redirect to the admin dashboard or to the bills list
        header("Location: administrator.php"); // Change the location as per your requirements
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Water Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Water Bill</h1>

        <!-- Form to Edit Bill -->
        <form method="POST">
            <div class="mb-3">
                <label for="CustomerID" class="form-label">Customer ID</label>
                <input type="text" class="form-control" id="CustomerID" name="CustomerID" value="<?php echo $bill['CustomerID']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Date" class="form-label">Date</label>
                <input type="date" class="form-control" id="Date" name="Date" value="<?php echo $bill['Date']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="WaterConsumption" class="form-label">Water Consumption (m³)</label>
                <input type="number" class="form-control" id="WaterConsumption" name="WaterConsumption" value="<?php echo $bill['WaterConsumption']; ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="AmountDue" class="form-label">Amount Due ($)</label>
                <input type="number" class="form-control" id="AmountDue" name="AmountDue" value="<?php echo $bill['AmountDue']; ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="Status" class="form-label">Status</label>
                <select class="form-control" id="Status" name="Status" required>
                    <option value="Paid" <?php echo $bill['Status'] == 'Paid' ? 'selected' : ''; ?>>Paid</option>
                    <option value="Unpaid" <?php echo $bill['Status'] == 'Unpaid' ? 'selected' : ''; ?>>Unpaid</option>
                    <option value="Pending" <?php echo $bill['Status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update Bill</button>
            <a href="administrator.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
