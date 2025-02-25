<!DOCTYPE html>
<html>
<head>
    <title>Purchase Confirmation</title>
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
        .container {
            max-width: 600px;
            margin: 350px auto;
            background-color: rgba(0, 0, 0, 0.5); /* Transparent black background */
            padding: 50px 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            text-align: center; /* Center align text */
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
    </style>
</head>
<body>
<div class="container">
<h2>Purchase Confirmed!</h2>
<p>Thank you for your purchase. Your order has been successfully submitted.</p>
<p>You will receive an email confirmation shortly.</p>
<p>Your Order will be delivered in three days</p>
<?php
$total = $_GET['total'];
echo "<p>The total bill amount is $total</p>";
?>
</div>
</body>
</html>


