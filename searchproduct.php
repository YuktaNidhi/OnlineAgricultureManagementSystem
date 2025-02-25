<?php
$servername = "localhost";
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "agroculture"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create the stored procedure if it does not exist
$createProcedureSQL = "
CREATE PROCEDURE IF NOT EXISTS GetProductsByName(IN productName VARCHAR(255))
BEGIN
    SELECT produce_id, produce_name, produce_type, price, expiry_date, availability, farmer_id 
    FROM produce 
    WHERE produce_name LIKE CONCAT('%', productName, '%');
END;
";

// Execute the SQL to create the stored procedure
$conn->query("DROP PROCEDURE IF EXISTS GetProductsByName");
if ($conn->query($createProcedureSQL) === TRUE) {
    // Stored procedure created successfully.
} else {
    echo "Error creating stored procedure: " . $conn->error;
}

$product_name = isset($_GET['produce_name']) ? $_GET['produce_name'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('img1.jpg'); /* Replace 'img1.jpg' with your image file path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ecdfdf;
        }
        .container {
            max-width: 800px;
            background-color: rgba(0, 0, 0, 0.5); /* Transparent black background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            overflow: auto;
            max-height: 80vh;
        }
        h1 {
            font-family: 'Times New Roman', Times, serif;
            font-size: 36px;
            color: rgb(231, 215, 193);
            margin-bottom: 20px;
        }
        label {
            font-family: 'Times New Roman', Times, serif;
            font-size: 24px;
            color: rgb(231, 215, 193);
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            font-size: 18px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 24px;
            border: white;
            background-color: transparent;
            color: #ecdfdf;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #afc8ee8c;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ecdfdf;
        }
        th {
            background-color: rgba(0, 0, 0, 0.7);
        }
        td {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search Product</h1>
        <form id="searchForm" method="GET" action="searchproduct.php">
            <label id="searchInputLabel" for="searchInput">Enter Product Name:</label>
            <input type="text" id="searchInput" name="produce_name" required>
            <input type="submit" class="btn" value="Submit"><br>
            <p><a href="searchbyfarmer.php" class="btn">SEARCH USING FARMER ID</a></p>
        </form>

        <?php
        if (!empty($product_name)) {
            // Prepare and execute the stored procedure
            $stmt = $conn->prepare("CALL GetProductsByName(?)");
            $stmt->bind_param("s", $product_name);
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            // Check if there are any results
            if ($result->num_rows > 0) {
                echo "<h2>Search Results for: " . htmlspecialchars($product_name) . "</h2>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Name</th><th>Type</th><th>Price</th><th>Expiry Date</th><th>Availability</th><th>Farmer ID</th></tr>";

                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["produce_id"] . "</td>";
                    echo "<td>" . $row["produce_name"] . "</td>";
                    echo "<td>" . $row["produce_type"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td>" . $row["expiry_date"] . "</td>";
                    echo "<td>" . $row["availability"] . "</td>";
                    echo "<td>" . $row["farmer_id"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No results found for: " . htmlspecialchars($product_name) . "</p>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<p>Please enter a product name.</p>";
        }

        // Close the connection
        $conn->close();
        ?>
    </div>
</body>
</html>




