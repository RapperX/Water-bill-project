<?php

session_start();
include('db.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sample authentication (not secure in real-life applications, use hashing for passwords)
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    // Database connection
    $conn = new mysqli('localhost', 'username', 'password', 'lifewithinus');
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepared statement for security (use prepared statements to avoid SQL injection)
    $stmt = $conn->prepare("SELECT * FROM Customers WHERE email = ? AND password = ?");
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        if ($password === $customer['password']){
        
        // Set session variables
        $_SESSION['CustomerID'] = $customer['CustomerID'];
        $_SESSION['firstname'] = $customer['firstname'];
        $_SESSION['lastname'] = $customer['lastname'];
        $_SESSION['Email'] = $customer['email'];
        $_SESSION['Phone'] = $customer['phone'];
        $_SESSION['Address'] = $customer['address'];
        
        // Redirect to the dashboard
        echo "welcome.";
        header('Location: mtejas.php');
        exit();
        }
    } else {
        $error = "Invalid credentials";
    }

    $stmt->close();
    $conn->close();
}
?>