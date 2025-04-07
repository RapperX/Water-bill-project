
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lifewithinus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM administrator WHERE name = '$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if ($password === $user['password']) {
        
            // Store user session
           

            // Redirect to mteja.php after successful login
            header("Location: administrator.php");
            exit();
        } else {
            
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that name.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Include your styles here -->
    <style>
    h1 {
       text-align: center;
       color:green;
   }
   body {
       font-family: Arial, sans-serif;
       display: flex;
       justify-content: center;
       align-items: center;
       height: 100vh;
       margin: 0;
       background-image: url('pic/water2.jpg');
       background-size: cover; 
       background-position: center; 
       background-repeat: no-repeat;
   }
   .login-form {
       background-color: white;
       padding: 20px;
       border-radius: 8px;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
       width: 300px;
   }
   .login-form h2 {
       text-align: center;
   }
   .login-form input {
       width: 100%;
       padding: 10px;
       margin: 10px 0;
       border: 1px solid #ccc;
       border-radius: 5px;
       box-sizing: border-box;
   }
   .login-form button {
       width: 100%;
       padding: 10px;
       background-color: #007bff;
       color: white;
       border: none;
       border-radius: 5px;
       cursor: pointer;
       font-size: 16px;
   }
   .login-form button:hover {
       background-color: #0056b3;
   }
   .login-form a {
       text-align: center;
       display: block;
       margin-top: 10px;
       color: #007bff;
       text-decoration: none;
   }
   .login-form a:hover {
       text-decoration: underline;
   }
</style>
</head>
<body>

    <div class="login-form">
        <h1>LIFE WITHIN US.</h1>
        <h2> ADMIN Login</h2>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your Name" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Log In</button>
        </form>
    </div>

</body>
</html>
