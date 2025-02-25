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

    // Retrieve customer_id from the form
    $customer_id = $_POST["customer_id"];

    // Retrieve customer's name and address
    $stmt_customer = $conn->prepare("SELECT name, address FROM customer_details WHERE customer_id = ?");
    $stmt_customer->bind_param("i", $customer_id);
    $stmt_customer->execute();
    $stmt_customer->bind_result($customer_name, $customer_address);
    $stmt_customer->fetch();
    $stmt_customer->close();

    // Prepare and bind SQL statement for inserting into cust_buy table
    $stmt_buy = $conn->prepare("INSERT INTO cust_buy (bill_no, p_id, p_price, quantity, total, farmer_id, customer_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt_buy->bind_param("iiiiiii", $bill_no, $p_id, $p_price, $quantity, $total_price, $farmer_id, $customer_id);

    // Prepare and bind SQL statement for inserting into total_customer_bill table
    $stmt_total = $conn->prepare("INSERT INTO total_customer_bill (bill_no, total, customer_id) VALUES (?, ?, ?)");
    $stmt_total->bind_param("iii", $bill_no, $total, $customer_id);

    // Prepare and bind SQL statement for inserting into product_delivery_details table
    $stmt_delivery = $conn->prepare("INSERT INTO product_delivery_details (bill_no, customer_name, customer_address, delivery_date, status) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 3 DAY), 'not delivered')");
    $stmt_delivery->bind_param("iss", $bill_no, $customer_name, $customer_address);

    // Initialize total variable
    $total = 0;

    // Generate a random 5-digit bill number
    $bill_no = mt_rand(10000, 99999);

    // Loop through each product detail
    foreach($_POST['p_id'] as $key => $p_id) {
        // Retrieve product price and farmer id from the database
        $stmt_product = $conn->prepare("SELECT price, farmer_id FROM produce WHERE produce_id = ?");
        $stmt_product->bind_param("i", $p_id);
        $stmt_product->execute();
        $stmt_product->bind_result($p_price, $farmer_id);
        $stmt_product->fetch();
        $stmt_product->close();

        // Assign values for each product
        $quantity = $_POST['quantity'][$key];
        $total_price = $p_price * $quantity; // Calculate total price
        $total += $total_price; // Add to total

        // Execute the SQL statement for inserting into cust_buy table
        $stmt_buy->execute();
    }

    // Execute the SQL statement for inserting into total_customer_bill table
    $stmt_total->execute();

    // Execute the SQL statement for inserting into product_delivery_details table
    $stmt_delivery->execute();

    // Close statements and connection
    $stmt_buy->close();
    $stmt_total->close();
    $stmt_delivery->close();
    $conn->close();

    // Redirect to a confirmation page
    header("Location: purchase_confirmation.php?total=$total");
    exit();
}
?>





