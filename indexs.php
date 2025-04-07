<?php
// Start session to manage login
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "lifewithinus";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect user inputs
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Prepare and execute query to fetch customer details by email
    $sql = "SELECT CustomerID, firstname, lastname, Password FROM Customers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user details
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user information in session
            $_SESSION['CustomerID'] = $user['CustomerID'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];

            // Redirect to user dashboard
            header('Location: mtejas.php');
            exit();
        } else {
            // Invalid password
            $error = "invalid password.";
        }
    } else {
        // Email not found
        $error = "Invalid email or password.";
    }
}

// Close the database connection
$conn->close();
?>

<!-- HTML Form (Your existing login form code goes here) -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('pic/g.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            color: black;
            text-align: center;
            font-size: 30px;
        }
        h1 {
            color: blue;
            text-align: center;
            font-size: 50px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-top: 20px;
        }

        label {
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            color: red;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div>
        <h1>LIFE WITHIN US.</h1>
        <form action="indexs.php" method="POST">
            <h2>LOGIN TO YOUR ACCOUNT</h2>
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>

        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </div>
</body>
</html>
