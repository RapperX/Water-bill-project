<?php
session_start();
if (!isset($_SESSION['CustomerID'])) {
    header('Location: indexs.php');
    exit();
}

$CustomerID = $_SESSION['CustomerID'];

// Database connection
$conn = new mysqli('localhost', 'username', 'password', 'lifewithinus');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bills
$sql = "SELECT * FROM WaterBills WHERE CustomerID = $CustomerID";
$bills_result = $conn->query($sql);

// Handle bill correction request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bill_id = $_POST['BillID'];
    $reason = $_POST['RequestDetails'];

    $sql = "INSERT INTO bill_corrections (CustomerID, BillID, RequestDetails) VALUES ($CustomerID, $BillID, '$RequestDetails')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Bill correction request submitted successfully!";
    } else {
        $error_message = "Error submitting correction request.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        h3 {
            color: #333;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        textarea {
            width: 100%;
            height: 80px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .message {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            font-weight: bold;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h2>Welcome to Your Dashboard</h2>

    <h3>Your Water Bills</h3>
    <table>
        <tr>
            <th>Bill ID</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Request Correction</th>
        </tr>
        <?php while ($bill = $bills_result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $bill['BillID']; ?></td>
            <td><?php echo $bill['AmountDue']; ?></td>
            <td><?php echo $bill['Date']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="BillID" value="<?php echo $bill['BillID']; ?>">
                    <textarea name="reason" placeholder="Enter reason for correction"></textarea><br><br>
                    <button type="submit">Request Correction</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <?php if (isset($success_message)) { echo "<div class='message success'>$success_message</div>"; } ?>
    <?php if (isset($error_message)) { echo "<div class='message error'>$error_message</div>"; } ?>

</body>
</html>
