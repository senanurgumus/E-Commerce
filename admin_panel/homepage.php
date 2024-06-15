<?php
include 'db_connect.php';

$sql = "SELECT * FROM products WHERE stock_quantity>0";
$result_products = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa - SenaHaven</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #000080;
            padding: 20px;
            color: white;
            text-align: center;
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

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .hero {
            text-align: center;
            margin-bottom: 20px;
        }

        .hero-flex {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .hero img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        h2 {
            font-size: 28px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #666;
        }

        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            margin: 20px 0;
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .product {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            width: 250px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .product p {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .product .price {
            font-weight: bold;
            color: #007bff;
            font-size: 16px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #000080;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .social-icons a {
            text-decoration: none;
            color: white;
            font-size: 20px;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: #3E8E41;
        }
    </style>
</head>

<body>
<header>
    <div class="sidebar">
        <h1>SenaHaven<br>E-Commerce</h1>
        <ul>
            <li><a href="homepage.php">Ana Sayfa</a></li>
            <li><img src="uploads/carticon.png" style="max-width: 30px; height: auto;" alt="Sepet"><a href="cart.php"> Sepet</a></li>
            <li><a href="contact.php">İletişim</a></li>
        </ul>
    </div>
</header>

<main class="container">
<form action="search_product.php" method="GET">
            <input type="text" name="query" placeholder="Ürün Ara...">
            <button type="submit">Ara</button>
        </form>
    <h2>Hoş Geldiniz!</h2>

    <div class="hero hero-flex">
        <img src="uploads/icon.jpeg" alt="Welcome Image">
        <img src="uploads/icon2.png" alt="Welcome Image 2">
    </div>

    <p>Harika fırsatları kaçırmayın: En kaliteli ürünleri en uygun fiyatlarla keşfedin!</p>

    <select onchange="location = this.value;">
        <option value="">Kategoriler</option>
        <?php
        $sql = "SELECT category_id, category_name FROM category_table ORDER BY category_order";
        $result_categories = $conn->query($sql);

        if ($result_categories->num_rows > 0) {
            while ($row = $result_categories->fetch_assoc()) {
                echo '<option value="category.php?category_id=' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
            }
        } else {
            echo '<option value="">Kategori bulunamadı</option>';
        }
        ?>
    </select>


    <div class="products">
        <?php
        if ($result_products->num_rows > 0) {
            while ($product = $result_products->fetch_assoc()) {
                echo '<div class="product">';
                echo '<h3>' . $product["product_name"] . '</h3>';
                echo '<a href="product_detail.php?product_id=' . $product["product_id"] . '"><img src="' . $product["product_image"] . '" alt="' . $product["product_name"] . '"></a>';
                echo '<p class="price">Fiyat: ' . $product["product_price"] . ' TL</p>';
                echo '</div>';
            }
        } else {
            echo '<p>Ürün bulunamadı.</p>';
        }
        ?>
    </div>

    <div class="social-icons">
        <a href="https://www.facebook.com" target="_blank"><img src="uploads/facebook.png" alt="Facebook" style="width: 30px; height: 30px;"></a>
        <a href="https://www.twitter.com" target="_blank"><img src="uploads/twitter.png" alt="Twitter" style="width: 30px; height: 30px;"></a>
        <a href="https://www.instagram.com" target="_blank"><img src="uploads/instagram.png" alt="Instagram" style="width: 30px; height: 30px;"></a>
        <a href="https://www.linkedin.com" target="_blank"><img src="uploads/linkedin.png" alt="LinkedIn" style="width: 30px; height: 30px;"></a>
    </div>

</main>

<footer>
    <p>2024 SenaHaven.com</p>
</footer>

</body>

</html>

<?php
$conn->close();
?>
