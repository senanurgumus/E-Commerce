<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Ver - Kargo Detayları</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eef2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            color: #fff;
            background-color: #007bff;
            text-align: center;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            margin: 20px auto 0;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .center-btn {
            text-align: center;
        }

        .order-form h3 {
            color: #444;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .order-form label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
            font-weight: bold;
        }

        .order-form input[type="text"],
        .order-form input[type="email"],
        .order-form input[type="tel"],
        .order-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .order-form textarea {
            resize: vertical;
        }

        .total-price {
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
            color: #28a745;
            text-align: center;
        }

        .order-details p {
            font-size: 16px;
            margin: 5px 0;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Sipariş Ver - Kargo Detayları</h1>
        <div class="center-btn">
            <a href="dashboard.php" class="btn">Dashboard'a Dön</a>
        </div>
        <div class="order-form">
            <form action="payment.php" method="post" id="orderForm">
                <div class="order-details">
                    <h3>Sipariş Detayları</h3>
                    <?php
                    if (isset($_POST['products']) && isset($_POST['quantities'])) {
                        $products = $_POST['products'];
                        $quantities = $_POST['quantities'];

                        include 'db_connect.php';
                        $total_price = 0;

                        for ($i = 0; $i < count($products); $i++) {
                            $product_id = (int)$products[$i];
                            $quantity = (int)$quantities[$i];

                            $sql = "SELECT product_name, product_price FROM products WHERE product_id = $product_id";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $product_name = $row['product_name'];
                                $product_price = $row['product_price'];
                                $total_price += $product_price * $quantity;

                                echo '<p>Ürün: ' . $product_name . ' - Adet: ' . $quantity . ' - Fiyat: ' . ($product_price * $quantity) . ' TL</p>';
                                echo '<input type="hidden" name="products[]" value="' . $product_id . '">';
                                echo '<input type="hidden" name="quantities[]" value="' . $quantity . '">';
                            }
                        }
                        $conn->close();

                        echo '<p class="total-price">Toplam Fiyat: ' . $total_price . ' TL</p>';
                        echo '<input type="hidden" name="total_price" value="' . $total_price . '">';
                    } else {
                        echo '<p>Sepetinizde ürün bulunmamaktadır.</p>';
                    }
                    ?>
                </div>
                <label for="first_name" class="fa fa-user">Adınız:</label>
                <input type="text" id="first_name" name="first_name" required>
                <label for="last_name" class="fa fa-user">Soyadınız:</label>
                <input type="text" id="last_name" name="last_name" required>
                <label for="email" class="fa fa-envelope">E-mail:</label>
                <input type="email" id="email" name="email" required>
                <label for="address" class="fa fa-address-card-o">Adres:</label>
                <textarea id="address" name="address" required></textarea>
                <label for="telephone_num" class="fa fa-phone">Telefon Numarası:</label><br>
                <input type="tel" id="telephone_num" name="telephone_num" required>
                <input type="hidden" id="name" name="name">
                <div class="center-btn">
                    <input type="submit" class="btn" value="İleri" onclick="combineNames()">
                </div>
            </form>
        </div>
    </div>
    <script>
        function combineNames() {
            var firstName = document.getElementById('first_name').value;
            var lastName = document.getElementById('last_name').value;
            document.getElementById('name').value = firstName + ' ' + lastName;
        }
    </script>
</body>

</html>
