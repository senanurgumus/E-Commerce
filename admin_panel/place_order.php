<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $telephone_num = $_POST['telephone_num'];
    $total_price = $_POST['total_price'];
    $products = $_POST['products'];
    $quantities = $_POST['quantities'];
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardnumber'];
    $expmonth = $_POST['expmonth'];
    $expyear = $_POST['expyear'];
    $cvv = $_POST['cvv'];
    $current_date = date("Y-m-d H:i:s");

    $sql_order = "INSERT INTO orders (customer_name, customer_email, shipping_address, total_amount, order_date, telephone_number) 
                  VALUES ('$name', '$email', '$address', $total_price, '$current_date', '$telephone_num')";

    if ($conn->query($sql_order) === TRUE) {
        $order_id = $conn->insert_id;

        for ($i = 0; $i < count($products); $i++) {
            $product_id = (int)$products[$i];
            $quantity = (int)$quantities[$i];

            $sql_order_item = "INSERT INTO order_items (order_id, product_id, quantity) 
                               VALUES ($order_id, $product_id, $quantity)";
            if ($conn->query($sql_order_item) !== TRUE) {
                echo "Error adding order item: " . $conn->error;
                exit;
            }

            $sql_update_stock = "UPDATE products SET stock_quantity = stock_quantity - $quantity 
                                 WHERE product_id = $product_id";
            if ($conn->query($sql_update_stock) !== TRUE) {
                echo "Error updating stock: " . $conn->error;
                exit;
            }
        }

        unset($_SESSION['cart']);

        echo "<link rel='stylesheet' type='text/css' href='styles.css'>";
        echo "<style>
                body, html {
                    height: 100%;
                    margin: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    font-family: Arial, sans-serif;
                }
                .center-content {
                    max-width: 600px;
                    margin: 20px;
                    padding: 20px;
                    border: 1px solid #ccc;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }
                .center-content table {
                    width: 100%;
                    margin-top: 20px;
                }
                .center-content th, .center-content td {
                    text-align: left;
                    padding: 8px;
                    border: 1px solid #ddd;
                }
                .center-content th {
                    background-color: #f2f2f2;
                }
                .btn {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    color: #fff;
                    background-color: #007bff;
                    text-decoration: none;
                    border-radius: 5px;
                }
                .btn:hover {
                    background-color: #0056b3;
                }
              </style>";
        echo "<div class='center-content'>";
        echo "<h1>Sipariş Detayları</h1>";
        echo "<h2>Siparişiniz başarıyla alındı</h2>";
        echo "<p>Sipariş numaranız: <strong>" . $order_id . "</strong></p>";

        echo "<h4>Müşteri Bilgileri</h4>";
        echo "<table>";
        echo "<tr><th>Adı Soyadı</th><td>$name</td></tr>";
        echo "<tr><th>Email</th><td>$email</td></tr>";
        echo "<tr><th>Adres</th><td>$address</td></tr>";
        echo "<tr><th>Toplam Fiyat</th><td>$total_price TL</td></tr>";
        echo "</table>";

        echo "<h3>Ürünler</h3>";
        echo "<table>";
        echo "<thead>";
        echo "<tr><th>Ürün Adı</th><th>Adet</th></tr>";
        echo "</thead>";
        echo "<tbody>";

        for ($i = 0; $i < count($products); $i++) {
            $product_id = (int)$products[$i];
            $quantity = (int)$quantities[$i];

            $sql_product_name = "SELECT product_name FROM products WHERE product_id = $product_id";
            $result_product_name = $conn->query($sql_product_name);
            if ($result_product_name->num_rows > 0) {
                $row_product_name = $result_product_name->fetch_assoc();
                $product_name = $row_product_name['product_name'];
            } else {
                $product_name = "Unknown";
            }

            echo "<tr>";
            echo "<td>" . $product_name . "</td>";
            echo "<td>" . $quantity . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        echo "<a href='dashboard.php' class='btn'>Dashboard'a Geri Dön</a>";
        echo "</div>";
    } else {
        echo "Sipariş eklenirken bir hata oluştu: " . $conn->error;
    }
} else {
    echo "Geçersiz istek.";
}

$conn->close();
?>
