<?php
// Database connection parameters
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "agroculture"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the procedure already exists
$sqlCheck = "SHOW PROCEDURE STATUS WHERE Db = '$dbname' AND Name = 'UpdateDeliveryStatus'";
$result = $conn->query($sqlCheck);

if ($result->num_rows == 0) {
    // Define the stored procedure
    $sqlProcedure = "
    CREATE PROCEDURE UpdateDeliveryStatus()
    BEGIN
        UPDATE product_delivery_details
        SET status = 'delivered'
        WHERE delivery_date = CURDATE();
    END";

    // Execute the procedure creation query
    if ($conn->query($sqlProcedure) === TRUE) {
        echo "Stored procedure created successfully. ";
    } else {
        echo "Error creating stored procedure: " . $conn->error;
    }
} else {
    echo "Stored procedure already exists. ";
}

// Prepare the SQL to call the stored procedure
$sqlCall = "CALL UpdateDeliveryStatus()";

// Execute the query
if ($conn->query($sqlCall) === TRUE) {
    echo "Delivery status updated successfully.";
} else {
    echo "Error updating delivery status: " . $conn->error;
}

// Close the connection
$conn->close();
?>

