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

    // Retrieve produce_id, new availability, new price, and new expiry date from the form
    $produce_id = $_POST["produce_id"];
    $new_availability = $_POST["new_availability"];
    $new_price = $_POST["new_price"];
    $new_expiry_date = $_POST["new_expiry_date"];

    // Prepare and bind SQL statement to update the produce details
    $stmt_update = $conn->prepare("UPDATE produce SET availability = availability + ?, price = ?, expiry_date = ? WHERE produce_id = ?");
    $stmt_update->bind_param("iiss", $new_availability, $new_price, $new_expiry_date, $produce_id);

    // Execute the SQL statement
    if ($stmt_update->execute()) {
        echo "Produce details updated successfully.";
    } else {
        echo "Error updating produce details: " . $stmt_update->error;
    }

    // Close statement and connection
    $stmt_update->close();
    $conn->close();
}
?>
