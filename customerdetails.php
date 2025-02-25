<?php
// Database connection parameters
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "agroculture"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);




// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$customer_id = $_POST['customer_id'];

// Prepare SQL statement
$sql = "INSERT INTO customer_details (name, address, phone, email, password, customer_id) 
        VALUES ('$name', '$address', '$phone', '$email', '$password', '$customer_id')";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    header("Location: dbms2.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
