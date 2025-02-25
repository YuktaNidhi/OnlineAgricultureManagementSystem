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

    // Retrieve soil_type from farmers table
    $stmt_soil = $conn->prepare("SELECT soil_type FROM farmers WHERE farmer_id = ?");
    $stmt_soil->bind_param("i", $farmer_id);
    $stmt_soil->execute();
    $stmt_soil->bind_result($soil_type);
    $stmt_soil->fetch();
    $stmt_soil->close();

    // Suggest crops based on soil_type
    $crops = "";
    if ($soil_type == "red soil") {
        $crops = "Cotton, Wheat, Sorghum, Maize";
    } elseif ($soil_type == "black soil") {
        $crops = "Cotton, Soybean, Sunflower, Sorghum";
    } elseif ($soil_type == "aluvial") {
        $crops = "Rice, Wheat, Sugarcane, Jute";
    } else {
        $crops = "Unknown soil type.";
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crop Suggestions</title>
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
    .content{
            max-width: 600px;
            margin: 350px auto;
            background-color: rgba(0, 0, 0, 0.5); /* Transparent black background */
            padding: 50px 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            text-align: center; /* Center align text */
            color: rgb(231, 215, 193);
        }
</style>
</head>
<body>

<div class="content">
    <h2>Crop Suggestions</h2>
    <p>Soil Type: <?php echo htmlspecialchars($soil_type); ?></p>
    <p>Crops that can be grown: <?php echo htmlspecialchars($crops); ?></p>
</div>

</body>
</html>
