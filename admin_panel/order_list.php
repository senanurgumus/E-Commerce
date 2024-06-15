<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="checkout.css">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #e9ecef;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow-x: auto;
        }

        h1 {
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #dee2e6;
        }

        td img {
            max-width: 50px;
            height: auto;
            margin-right: 5px;
            border-radius: 4px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            text-align: center;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            max-width: 300px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Set specific column widths */
        th:nth-child(1),
        td:nth-child(1) {
            width: 5%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 10%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 15%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 10%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 10%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 10%;
        }

        th:nth-child(7),
        td:nth-child(7) {
            width: 15%;
        }

        th:nth-child(8),
        td:nth-child(8) {
            width: 10%;
        }

        th:nth-child(9),
        td:nth-child(9) {
            width: 10%;
        }

        th:nth-child(10),
        td:nth-child(10) {
            width: 5%;
        }

        th:nth-child(11),
        td:nth-child(11) {
            width: 10%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Order Details</h1>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Telephone Number</th>
                    <th>Shipping Address</th>
                    <th>Products</th>
                    <th>Product Images</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                $sql = "SELECT orders.*, GROUP_CONCAT(products.product_name SEPARATOR ', ') AS product_names, GROUP_CONCAT(products.product_image SEPARATOR ', ') AS product_images, SUM(order_items.quantity) AS total_quantity
                            FROM orders
                            INNER JOIN order_items ON orders.order_id = order_items.order_id
                            INNER JOIN products ON order_items.product_id = products.product_id
                            GROUP BY orders.order_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["order_id"] . "</td>";
                        echo "<td>" . $row["customer_name"] . "</td>";
                        echo "<td>" . $row["customer_email"] . "</td>";
                        echo "<td>" . $row["order_date"] . "</td>";
                        echo "<td>TRY " . $row["total_amount"] . "</td>";
                        echo "<td>" . $row["telephone_number"] . "</td>";
                        echo "<td>" . $row["shipping_address"] . "</td>";
                        echo "<td>" . $row["product_names"] . "</td>";
                        echo "<td>";
                        $images = explode(", ", $row["product_images"]);
                        foreach ($images as $image) {
                            echo "<img src='" . $image . "' alt='Product Image'>";
                        }
                        echo "</td>";
                        echo "<td>" . $row["total_quantity"] . "</td>";
                        echo "<td><a href='edit_order.php?id=" . $row["order_id"] . "'>Edit</a> 
                        <a href='delete_order.php?id=" . $row["order_id"] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No orders found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <div class="btn-container">
            <a href="dashboard.php" class="btn">Return to the Dashboard</a>
        </div>
    </div>
</body>

</html>
