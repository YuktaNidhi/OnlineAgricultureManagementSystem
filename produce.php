<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Retrieve form data
$produce_name = $_POST['produce_name'];
$produce_type = $_POST['produce_type'];
$price = $_POST['price'];
$expiry_date = $_POST['expiry_date'];
$availability = $_POST['availability'];
$produce_id = $_POST['produce_id'];
$farmer_id = $_POST['farmer_id'];

// Create connection
$conn = new mysqli('localhost', 'root', '', 'agroculture');


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Prepare SQL statement
$sql = "INSERT INTO produce (produce_id, produce_name, produce_type, price, expiry_date, availability,farmer_id) 
        VALUES ('$produce_id', '$produce_name', '$produce_type', '$price', '$expiry_date', '$availability','$farmer_id')";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    echo "Produce details uploaded successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
}
?>
