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

    // Retrieve farmer_id from the form
    $farmer_id = $_POST["farmer_id"];

    // Retrieve farmer name and address from farmers table
    $stmt_farmer = $conn->prepare("SELECT name, address FROM farmers WHERE farmer_id = ?");
    $stmt_farmer->bind_param("i", $farmer_id);
    $stmt_farmer->execute();
    $stmt_farmer->bind_result($farmer_name, $farmer_address);
    $stmt_farmer->fetch();
    $stmt_farmer->close();

    // Prepare and bind SQL statement for inserting into kit_buy table
    $stmt_buy = $conn->prepare("INSERT INTO kit_buy (bill_no, kit_id, kit_price, quantity, total, supplier_id, farmer_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt_buy->bind_param("iiiiiii", $bill_no, $kit_id, $kit_price, $quantity, $total_price, $supplier_id, $farmer_id);

    // Prepare and bind SQL statement for inserting into total_farmer_bill table
    $stmt_total = $conn->prepare("INSERT INTO total_farmer_bill (bill_no, total, farmer_id) VALUES (?, ?, ?)");
    $stmt_total->bind_param("iii", $bill_no, $total, $farmer_id);

    // Initialize total variable
    $total = 0;

    // Generate a random 5-digit bill number
    $bill_no = mt_rand(10000, 99999);

    // Loop through each kit detail
    foreach($_POST['k_id'] as $key => $kit_id) {
        // Retrieve kit_price and supplier_id from the kit table
        $stmt_kit = $conn->prepare("SELECT kit_price, supplier_id FROM kit WHERE kit_id = ?");
        $stmt_kit->bind_param("i", $kit_id);
        $stmt_kit->execute();
        $stmt_kit->bind_result($kit_price, $supplier_id);
        $stmt_kit->fetch();
        $stmt_kit->close();

        // Assign values for each product
        $quantity = $_POST['quantity'][$key];
        $total_price = $kit_price * $quantity; // Calculate total price
        $total += $total_price; // Add to total

        // Execute the SQL statement for inserting into kit_buy table
        $stmt_buy->execute();
    }

    // Execute the SQL statement for inserting into total_farmer_bill table
    $stmt_total->execute();

    // Prepare and bind SQL statement for inserting into kit_delivery_details table
    $delivery_date = date('Y-m-d', strtotime('+3 days'));
    $status = 'not delivered';
    $stmt_delivery = $conn->prepare("INSERT INTO kit_delivery_details (bill_no, farmer_name, farmer_address, delivery_date, status) VALUES (?, ?, ?, ?, ?)");
    $stmt_delivery->bind_param("issss", $bill_no, $farmer_name, $farmer_address, $delivery_date, $status);

    // Execute the SQL statement for inserting into kit_delivery_details table
    $stmt_delivery->execute();

    // Close statements and connection
    $stmt_buy->close();
    $stmt_total->close();
    $stmt_delivery->close();
    $conn->close();

    // Redirect to a confirmation page
    header("Location: kitpurchase_confirmation.php?total=$total");
    exit();
}
?>

