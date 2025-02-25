<?php
// Retrieve form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$email = $_POST['email'];
$password = $_POST['password'];

// Database connection parameters
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "agroculture"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if login credentials exist in the supplier table
$sql_supplier = "SELECT * FROM supplier_details WHERE email = '$email' AND password = '$password'";
$result_supplier = $conn->query($sql_supplier);
if ($result_supplier->num_rows > 0) {
    // Successful login for supplier, redirect to home page
    echo "<script>window.location.href='dbms2.html';</script>";
    exit;
}


$sql_farmers = "SELECT * FROM farmers WHERE email = '$email' AND password = '$password'";
$result_farmers = $conn->query($sql_farmers);
if ($result_farmers->num_rows > 0) {
    // Successful login for farmer, redirect to home page
    echo "<script>window.location.href='dbms2.html';</script>";
    exit;
}

// Check if login credentials exist in the customer table
$sql_customer = "SELECT * FROM customer_details WHERE email = '$email' AND password = '$password'";
$result_customer = $conn->query($sql_customer);
if ($result_customer->num_rows > 0) {
    // Successful login for customer, redirect to home page
    echo "<script>window.location.href='dbms2.html';</script>";
    exit;
}

// Invalid credentials, redirect back to login page with an error message
echo "<script>window.location.href='dbms2.html';</script>";
exit;

// Close connection
$conn->close();
}
?>


