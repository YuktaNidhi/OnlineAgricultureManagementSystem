<?php
// Connection to MySQL database
$servername = "localhost";
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "agroculture"; // Change to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $kit_name = $_POST["kit_name"];
    $kit_price = $_POST["kit_price"];
    $supplier_id = $_POST["supplier_id"];
    $kit_id = $_POST["kit_id"];
    $availability = $_POST["availability"];


    // Insert data into the kit table
    $sql = "INSERT INTO kit (kit_id, kit_name, kit_price, supplier_id, availability) VALUES ('$kit_id', '$kit_name', '$kit_price', '$supplier_id', '$availability')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>