<?php
session_start();
include 'db_connect.php';

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

$sql = "SELECT category_name FROM category_table WHERE category_id = $category_id";
$result = $conn->query($sql);
$category_name = "Kategori bulunamadı";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $category_name = $row['category_name'];
}

$sql_products = "SELECT product_id, product_name, product_image, product_price, product_description, stock_quantity FROM products WHERE category_id = $category_id AND stock_quantity>0";
$result_products = $conn->query($sql_products);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category_name; ?> - E-Ticaret Sitesi</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        header {
            background-color: #000080;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        header nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            margin: 0;
        }

        header nav ul li {
            margin: 0 15px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        header nav ul li a:hover {
            text-decoration: underline;
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
            background-color: #C0C0C0 ;
            text-decoration: underline;
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            margin-bottom: 20px;
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 0 auto 20px auto;
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .product {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            width: 200px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            cursor: pointer;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
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
            text-align: center;
        }

        .product p {
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }

        .product .price {
            font-weight: bold;
            color: #007bff;
            font-size: 16px;
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #4CAF50;
            color: #fff;
            margin-top: 20px;
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
    <main>
        <form action="search_product.php" method="GET">
            <input type="text" name="query" placeholder="Ürün Ara...">
            <button type="submit">Ara</button>
        </form>
        <div style="margin-bottom: 20px;"></div> <!-- Added space between search and category select -->
        <select onchange="location = this.value;">
            <option value="">Kategori Seç</option>
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
        <h2><?php echo $category_name; ?> Kategorisi</h2>
        <div class="products">
            <?php
            if ($result_products->num_rows > 0) {
                while ($product = $result_products->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<h3>' . htmlspecialchars($product["product_name"]) . '</h3>';
                    echo '<a href="product_detail.php?product_id=' . (int)$product["product_id"] . '"><img src="' . htmlspecialchars($product["product_image"]) . '" alt="' . htmlspecialchars($product["product_name"]) . '" class="product-image"></a>';
                    echo '<p class="price">Fiyat: ' . number_format((float)$product["product_price"], 2) . ' TL</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>Bu kategoride ürün bulunmamaktadır.</p>';
            }
            ?>
        </div>
    </main>
</body>

</html>

<?php
$conn->close();
?>
