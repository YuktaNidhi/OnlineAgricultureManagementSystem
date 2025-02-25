<!DOCTYPE html>
<html>
<head>
    <title>Kit List</title>
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
<h1>Kits for Farmers</h1>

<table>
    <tr>
        <th>Kit ID</th>
        <th>Kit Name</th>
        <th>Price</th>
        <th>Availability</th>
        <th>Supplier's ID</th>
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
    $sql = "SELECT kit_id, kit_name,kit_price,supplier_id,availability FROM kit";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["kit_id"]. "</td>";
            echo "<td>" . $row["kit_name"]. "</td>";
            echo "<td>" . $row["kit_price"]. "</td>";
            echo "<td>" . $row["availability"]. "</td>";
            echo "<td>" . $row["supplier_id"]. "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>0 results</td></tr>";
    }

    $conn->close();
    ?>
</table>

<br>
<a href="buy_kit.html">Buy Now</a>
</div>
</body>
</html>