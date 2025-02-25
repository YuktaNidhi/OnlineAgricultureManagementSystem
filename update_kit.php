<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Retrieve kit_id, new availability, and new price from the form
    $kit_id = $_POST["kit_id"];
    $new_availability = $_POST["new_availability"];
    $new_price = $_POST["new_price"];

    // Prepare and bind SQL statement to update the kit details
    $stmt_update = $conn->prepare("UPDATE kit SET availability = availability + ?, kit_price = ? WHERE kit_id = ?");
    $stmt_update->bind_param("iis", $new_availability, $new_price, $kit_id);

    // Execute the SQL statement
    if ($stmt_update->execute()) {
        echo "Kit details updated successfully.";
    } else {
        echo "Error updating kit details: " . $stmt_update->error;
    }

    // Close statement and connection
    $stmt_update->close();
    $conn->close();
}
?>
