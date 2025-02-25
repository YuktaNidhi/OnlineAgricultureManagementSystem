<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('img1.jpg'); /* Replace 'background-image.jpg' with your image file path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h2 {
            text-align: center;
            font-family: 'Times New Roman';
            font-size: 40px;
            color: rgb(231, 215, 193);
        }
        p {
            text-align: center;
            font-family: 'Times New Roman';
            font-size: 30px;
            color: rgb(231, 215, 193);
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            font-family: 'Times New Roman';
            font-size: 40px;
            margin-bottom: 10px;
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
        .hidden {
            display: none;
        }
        .search-container {
            margin-top: 20px;
        }
        .container {
            max-width: 600px;
            margin: 350px auto;
            background-color: rgba(0, 0, 0, 0.5); /* Transparent black background */
            padding: 50px 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            text-align: center; /* Center align text */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color: rgb(231, 215, 193);
        }
    </style>
</head>
<body>
<div class="container">
<h1>Products</h1>

<table>
    <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Product Type</th>
        <th>Price</th>
        <th>Expiry Date</th>
        <th>Availability</th>
        <th>Farmer's ID</th>
    </tr>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root"; // Your MySQL username
    $password = ""; // Your MySQL password
    $database = "agroculture"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch data
    $sql = "SELECT produce_id, produce_name, produce_type,price, expiry_date, availability, farmer_id FROM produce";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["produce_id"]. "</td>";
            echo "<td>" . $row["produce_name"]. "</td>";
            echo "<td>" . $row["produce_type"]. "</td>";
            echo "<td>" . $row["price"]. "</td>";
            echo "<td>" . $row["expiry_date"]. "</td>";
            echo "<td>" . $row["availability"]. "</td>";
            echo "<td>" . $row["farmer_id"]. "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>0 results</td></tr>";
    }

    $conn->close();
    ?>
</table>

<br>
<a href="buy_form.html">Buy Now</a>
</div>
</body>
</html>