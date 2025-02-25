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
CREATE PROCEDURE IF NOT EXISTS GetProductsByFarmerID(IN farmerID INT)
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE prodID INT;
    DECLARE prodName VARCHAR(255);
    DECLARE prodType VARCHAR(255);
    DECLARE prodPrice DECIMAL(10, 2);
    DECLARE prodExpiryDate DATE;
    DECLARE prodAvailability INT;
    DECLARE farmerIDVal INT;
    DECLARE cur CURSOR FOR 
        SELECT produce_id, produce_name, produce_type, price, expiry_date, availability, farmer_id 
        FROM produce 
        WHERE farmer_id = farmerID;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    OPEN cur;
    product_loop: LOOP
        FETCH cur INTO prodID, prodName, prodType, prodPrice, prodExpiryDate, prodAvailability, farmerIDVal;
        IF done THEN
            LEAVE product_loop;
        END IF;
        SELECT prodID, prodName, prodType, prodPrice, prodExpiryDate, prodAvailability, farmerIDVal;
    END LOOP;
    CLOSE cur;
END;
";

// Execute the SQL to create the stored procedure
$conn->query("DROP PROCEDURE IF EXISTS GetProductsByFarmerID");
if ($conn->query($createProcedureSQL) === TRUE) {
    // Stored procedure created successfully.
} else {
    echo "Error creating stored procedure: " . $conn->error;
}

$farmer_id = isset($_GET['farmer_id']) ? $_GET['farmer_id'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Product by Farmer ID</title>
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
        <h1>Search Product by Farmer ID</h1>
        <form method="GET" action="">
            <label for="farmer_id">Enter Farmer ID:</label><br>
            <input type="text" id="farmer_id" name="farmer_id" value="<?php echo htmlspecialchars($farmer_id); ?>"><br>
            <button type="submit">Search</button>
        </form>

        <?php
        if (!empty($farmer_id)) {
            // Execute the stored procedure with the provided parameters
            $sql = "CALL GetProductsByFarmerID(?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $farmer_id);
            $stmt->execute();
            $stmt->bind_result($prodID, $prodName, $prodType, $prodPrice, $prodExpiryDate, $prodAvailability, $farmerIDVal);

            // Display the results in a table
            echo "<table>";
            echo "<tr><th>Produce ID</th><th>Produce Name</th><th>Produce Type</th><th>Price</th><th>Expiry Date</th><th>Availability</th><th>Farmer ID</th></tr>";
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $prodID . "</td>";
                echo "<td>" . $prodName . "</td>";
                echo "<td>" . $prodType . "</td>";
                echo "<td>" . $prodPrice . "</td>";
                echo "<td>" . $prodExpiryDate . "</td>";
                echo "<td>" . $prodAvailability . "</td>";
                echo "<td>" . $farmerIDVal . "</td>";
                echo "</tr>";
            }
            echo "</table>";

            // Close statement and connection
            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
</body>
</html>