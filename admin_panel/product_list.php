<?php
include 'db_connect.php';

$sql_products = "SELECT * FROM products";
$result_products = $conn->query($sql_products);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }

        h2 {
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th,
        td {
            padding: 20px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        td img {
            max-width: 50px;
            height: auto;
            margin-right: 5px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="stylesheet" href="checkout.css">

</head>

<body>

    <h2>Product List</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Picture</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Description</th>
            <th>Category ID</th>
            <th>Operations</th>
        </tr>
        <?php
        if ($result_products->num_rows > 0) {
            while ($row = $result_products->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["product_id"] . "</td>";
                echo "<td>" . $row["product_name"] . "</td>";
                echo "<td><img class='product-image' src='" . $row["product_image"] . "' alt='Product Image'></td>";
                echo "<td>" . $row["product_price"] . "</td>";
                echo "<td>" . $row["stock_quantity"] . "</td>";
                echo "<td>" . $row["product_description"] . "</td>";
                echo "<td>" . $row["category_id"] . "</td>";
                echo "<td>";
                echo "<form method='post' action='delete_product.php'><input type='hidden' name='product_id' value='" . $row["product_id"] . "'><input type='submit' value='Delete'></form><br>";
                echo "<form method='post' action='edit_product.php'><input type='hidden' name='product_id' value='" . $row["product_id"] . "'><input type='submit' value='Edit'></form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Product Not Found.</td></tr>";
        }
        ?>
    </table>
    <br><br>
    <a href="dashboard.php" class="btn">Return to the Dashboard</a>

</body>

</html>
