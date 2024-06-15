<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Ver - Ödeme</title>
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

        .icon-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .icon-container i {
            margin: 0 10px;
            font-size: 36px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .col-50 {
            flex: 48%;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Sipariş Ver - Ödeme</h1>
        <div class="center-btn">
            <a href="dashboard.php" class="btn">Dashboard'a Dön</a>
        </div>
        <div class="order-form">
            <form action="place_order.php" method="post">
                <div class="order-details">
                    <h3>Sipariş Detayları</h3>
                    <?php
                    if (isset($_POST['products']) && isset($_POST['quantities']) && isset($_POST['total_price'])) {
                        $products = $_POST['products'];
                        $quantities = $_POST['quantities'];
                        $total_price = $_POST['total_price'];

                        for ($i = 0; $i < count($products); $i++) {
                            $product_id = (int)$products[$i];
                            $quantity = (int)$quantities[$i];

                            include 'db_connect.php';
                            $sql = "SELECT product_name FROM products WHERE product_id = $product_id";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $product_name = $row['product_name'];
                                echo '<p>Ürün: ' . $product_name . ' - Adet: ' . $quantity . '</p>';
                            }
                            $conn->close();

                            echo '<input type="hidden" name="products[]" value="' . $product_id . '">';
                            echo '<input type="hidden" name="quantities[]" value="' . $quantity . '">';
                        }

                        echo '<p>Toplam Fiyat: ' . $total_price . ' TL</p>';
                        echo '<input type="hidden" name="total_price" value="' . $total_price . '">';
                    } else {
                        echo '<p>Geçersiz sipariş bilgisi.</p>';
                        exit;
                    }

                    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['address'])) {
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $address = $_POST['address'];
                        $telephone_num = $_POST['telephone_num'];

                        echo '<input type="hidden" name="name" value="' . $name . '">';
                        echo '<input type="hidden" name="email" value="' . $email . '">';
                        echo '<input type="hidden" name="address" value="' . $address . '">';
                        echo '<input type="hidden" name="telephone_num" value="' . $telephone_num . '">';
                    } else {
                        echo '<p>Geçersiz Kargo Bilgisi.</p>';
                        exit;
                    }
                    ?>
                </div>
                <h3>Ödeme</h3>
                <label for="fname">Kabul Edilen Kartlar</label>
                <div class="icon-container">
                    <i class="fa fa-cc-visa" style="color:navy;"></i>
                    <i class="fa fa-cc-amex" style="color:blue;"></i>
                    <i class="fa fa-cc-mastercard" style="color:red;"></i>
                    <i class="fa fa-cc-discover" style="color:orange;"></i>
                </div>
                <label for="cname">Kart Üzerindeki İsim</label>
                <input type="text" id="cname" name="cardname" placeholder="John More Doe" required>
                <label for="ccnum">Kredi Kartı Numarası</label>
                <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" required>
                <label for="expmonth">Son Kullanma Tarihi (Ay)</label>
                <input type="text" id="expmonth" name="expmonth" placeholder="Eylül" required>
                <div class="row">
                    <div class="col-50">
                        <label for="expyear">Son Kullanma Tarihi (Yıl)</label>
                        <input type="text" id="expyear" name="expyear" placeholder="2024" required>
                    </div>
                    <div class="col-50">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="352" required>
                    </div>
                </div>
                <div class="center-btn">
                    <input type="submit" class="btn" value="Sipariş Ver">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
