<?php
// Database connection
$servername = "localhost";
$username = "root";  // Your database username
$password = "";  // Your database password
$dbname = "lifewithinus";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['Phone'];  // Fixed variable name
    $email = $_POST['Email'];
    $address = $_POST['Address'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO Customers (firstname, lastname, Phone, Email, Address, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $phone, $email, $address, $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        echo "New record created successfully.";
        header("Location: indexs.php"); // Redirect to login page after successful registration
        exit(); // Make sure to stop script execution after header redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Include your styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('pic/g.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .registration-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h1 {
            text-align: center;
            color: green;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .input-field:focus {
            border-color: #4e90d1;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #4e90d1;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #3578b2;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-link a {
            color: #4e90d1;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="registration-container">
        <h1>LIFE WITHIN US.</h1>
        <h2>Create Account</h2>
        <form method="POST">
            <input type="text" name="firstname" class="input-field" placeholder="First Name" required>
            <input type="text" name="lastname" class="input-field" placeholder="Last Name" required>
            <input type="text" name="Phone" class="input-field" maxlength="10" placeholder="Phone Number" required>
            <input type="email" name="Email" class="input-field" placeholder="Email" required>
            <input type="text" name="Address" class="input-field" placeholder="Address" required>
            <input type="password" name="Password" class="input-field" placeholder="Password" required>
            <button type="submit" class="btn">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>

</body>
</html>
