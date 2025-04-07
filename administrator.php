<?php
// admin.php

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lifewithinus";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get Customers, WaterBills, and CorrectionRequests
$customersQuery = "SELECT * FROM Customers";
$customersResult = $conn->query($customersQuery);

$waterBillsQuery = "SELECT * FROM WaterBills";
$waterBillsResult = $conn->query($waterBillsQuery);

$correctionsQuery = "SELECT * FROM CorrectionRequests";
$correctionsResult = $conn->query($correctionsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Admin Dashboard</h1>

        <!-- Customers Table -->
        <h3>Customers</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>CustomerID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $customersResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['CustomerID']; ?></td>
                        <td><?php echo $row['firstname']; ?></td>
                        <td><?php echo $row['lastname']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['Phone']; ?></td>
                        <td><?php echo $row['Address']; ?></td>
                        <td>
                            <a href="editcustomer.php?id=<?php echo $row['CustomerID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="deletecustomer.php?id=<?php echo $row['CustomerID']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- WaterBills Table -->
        <h3>Water Bills</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>BillID</th>
                    <th>CustomerID</th>
                    <th>Date</th>
                    <th>Water Consumption</th>
                    <th>Amount Due</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $waterBillsResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['BillID']; ?></td>
                        <td><?php echo $row['CustomerID']; ?></td>
                        <td><?php echo $row['Date']; ?></td>
                        <td><?php echo $row['WaterConsumption']; ?> m³</td>
                        <td><?php echo $row['AmountDue']; ?> $</td>
                        <td><?php echo $row['Status']; ?></td>
                        <td>
                            <a href="editbill.php?id=<?php echo $row['BillID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="deletebill.php?id=<?php echo $row['BillID']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Correction Requests Table -->
        <h3>Correction Requests</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>RequestID</th>
                    <th>BillID</th>
                    <th>Request Details</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $correctionsResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['RequestID']; ?></td>
                        <td><?php echo $row['BillID']; ?></td>
                        <td><?php echo $row['RequestDetails']; ?></td>
                        <td><?php echo $row['Status']; ?></td>
                        <td>
                            <a href="editcorrection.php?id=<?php echo $row['RequestID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="deletecorrection.php?id=<?php echo $row['RequestID']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="addcustomer.php" class="btn btn-primary">Add Customer</a>
        <a href="addBill.php" class="btn btn-primary">Add Water Bill</a>
        <a href="addCorrection.php" class="btn btn-primary">Add Correction Request</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
