<?php
include 'db_connect.php';

$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die('Ürün bulunamadı.');
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <div class="sidebar">
            <h1>SenaHaven<br>E-Commerce</h1>
            <ul>
                <li><a href="homepage.php">Ana Sayfa</a></li>
                <li><img src="uploads/carticon.png" style="max-width: 30px; height: auto;" alt="Sepet"><a href="cart.php"> Sepet</a></li>
                <li><a href="contact.php">İletişim</a></li>
            </ul>
        </div>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> - Ürün Detayı</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        header {
            background-color: #000080;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .product-detail {
            max-width: 600px;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product-detail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .product-detail h1, .product-detail h2 {
            color: #007bff;
            margin-bottom: 10px;
        }

        .product-detail p {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        .product-detail .price {
            font-weight: bold;
            color: #28a745;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .product-detail form {
            margin-top: 20px;
        }

        .product-detail label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        .product-detail input[type="number"] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100px;
            margin-bottom: 10px;
        }

        .product-detail button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product-detail button:hover {
            background-color: #0056b3;
        }
        .sidebar {
            background-color: #000080;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidebar h1 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 10px 15px;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #C0C0C0;
            text-decoration: underline;
        }

    </style>
</head>

<body>
    <header>
    <div class="product-detail">
        <h1>Ürün Detayları</h1>
        <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
        <h2><?php echo $product['product_name']; ?></h2>
        <p>Ürün Açıklaması: <?php echo $product['product_description']; ?></p>
        <p class="price">Fiyat: <?php echo $product['product_price']; ?> TL</p>
        <p>Stok Miktarı: <?php echo $product['stock_quantity']; ?></p>
        <form action="add_to_cart.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $product['product_price']; ?>">
            <label for="quantity">Adet:</label>
            <input type="number" id="quantity" name="product_quantity" min="1" value="1">
            <button type="submit">Sepete Ekle</button>
        </form>
    </div>
    </header>
</body>

</html>

<?php
$conn->close();
?>
