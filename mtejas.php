<?php
include('db.php');
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lifewithinus";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's CustomerID from the session
session_start();
$CustomerID = $_SESSION['CustomerID'];  // Ensure the customer is logged in

// Fetch customer details
$sql_customer = "SELECT * FROM Customers WHERE CustomerID = ?";
$stmt_customer = $conn->prepare($sql_customer);
$stmt_customer->bind_param('i', $customerID);
$stmt_customer->execute();
$result_customer = $stmt_customer->get_result();
$customer = $result_customer->fetch_assoc();

// Fetch the user's water bills
$sql_bills = "SELECT * FROM WaterBills WHERE CustomerID = ?";
$stmt_bills = $conn->prepare($sql_bills);
$stmt_bills->bind_param('i', $customerID);
$stmt_bills->execute();
$water_bills_result = $stmt_bills->get_result();

// Fetch correction requests if any
$sql_requests = "SELECT * FROM CorrectionRequests WHERE BillID IN (SELECT BillID FROM WaterBills WHERE CustomerID = ?)";
$stmt_requests = $conn->prepare($sql_requests);
$stmt_requests->bind_param('i', $customerID);
$stmt_requests->execute();
$correction_requests_result = $stmt_requests->get_result();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, <?php echo $firstname; ?></title>
    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
        }

        /* Container for the page content */
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Header styling */
        h1 {
            color: #2c3e50;
            font-size: 2em;
            margin-bottom: 20px;
        }

        h2 {
            color: #34495e;
            font-size: 1.5em;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        /* Information styling */
        p {
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        strong {
            color: #2c3e50;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: #fff;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        /* Link styling */
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
<h1>Welcome, <?php echo htmlspecialchars($customer['firstname']) . ' ' . htmlspecialchars($customer['lastname']); ?>!</h1>
<p><strong>Name:</strong> <?php echo htmlspecialchars($customer['firstname']) . ' ' . htmlspecialchars($customer['lastname']); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($customer['Email']); ?></p>
<p><strong>Phone:</strong> <?php echo htmlspecialchars($customer['Phone']); ?></p>
<p><strong>Address:</strong> <?php echo htmlspecialchars($customer['Address']); ?></p>


    <div class="container">
        <h1>Welcome, <?php echo $firstname . ' ' . $lastname; ?>!</h1>

        <!-- Display customer information -->
        <p><strong>Name:</strong> <?php echo $firstname . ' ' . $lastname; ?></p>
        <p><strong>Email:</strong> <?php echo $Email; ?></p>
        <p><strong>Phone:</strong> <?php echo $Phone; ?></p>
        <p><strong>Address:</strong> <?php echo $Address; ?></p>

        <h2>Your Water Bills</h2>
        <table>
            <tr>
                <th>Bill Date</th>
                <th>Water Consumption (m³)</th>
                <th>Amount Due</th>
                <th>Status</th>
            </tr>

            <?php
            if ($water_bills_result->num_rows > 0) {
                while($bill = $water_bills_result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $bill['Date'] . "</td>
                            <td>" . $bill['WaterConsumption'] . "</td>
                            <td>" . $bill['AmountDue'] . "</td>
                            <td>" . $bill['Status'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No water bills found.</td></tr>";
            }
            ?>

        </table>

        <a href="logout.php">Logout</a>
    </div>
    <h2>Your Water Bills</h2>
<table>
    <tr>
        <th>Bill Date</th>
        <th>Water Consumption (m³)</th>
        <th>Amount Due</th>
        <th>Status</th>
    </tr>

    <?php
    if ($water_bills_result->num_rows > 0) {
        while($bill = $water_bills_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($bill['Date']) . "</td>
                    <td>" . htmlspecialchars($bill['WaterConsumption']) . "</td>
                    <td>" . htmlspecialchars($bill['AmountDue']) . "</td>
                    <td>" . htmlspecialchars($bill['Status']) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No water bills found.</td></tr>";
    }
    ?>
</table>

<h2>Your Correction Requests</h2>
<table>
    <tr>
        <th>Bill Date</th>
        <th>Request Details</th>
        <th>Status</th>
    </tr>

    <?php
    if ($correction_requests_result->num_rows > 0) {
        while($request = $correction_requests_result->fetch_assoc()) {
            // Fetch the corresponding bill for the correction request
            $billID = $request['BillID'];
            $sql_bill = "SELECT Date FROM WaterBills WHERE BillID = ?";
            $stmt_bill = $conn->prepare($sql_bill);
            $stmt_bill->bind_param('i', $billID);
            $stmt_bill->execute();
            $result_bill = $stmt_bill->get_result();
            $bill = $result_bill->fetch_assoc();
            
            echo "<tr>
                    <td>" . htmlspecialchars($bill['Date']) . "</td>
                    <td>" . htmlspecialchars($request['RequestDetails']) . "</td>
                    <td>" . htmlspecialchars($request['Status']) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No correction requests found.</td></tr>";
    }
    ?>
</table>


</body>
</html>

<?php
$conn->close();
?>
