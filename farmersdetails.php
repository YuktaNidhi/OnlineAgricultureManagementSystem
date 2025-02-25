<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $farmer_id = $_POST['farmer_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $soil_type = $_POST['soil_type'];
    $water_availability = $_POST['water_availability'];

    // Connect to your database
    // Replace 'localhost', 'username', 'password', and 'database_name' with your actual database credentials
    $conn = new mysqli('localhost', 'root', '', 'agroculture');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO farmers (farmer_id, name, address, email, password, phone, soil_type, water_availability)
            VALUES ('$farmer_id', '$name', '$address', '$email', '$password', '$phone', '$soil_type', '$water_availability')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        header("Location: dbms2.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>