<?php
session_start();

if (isset($_GET['remove']) && isset($_SESSION['cart'])) {
    $remove_id = $_GET['remove'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['product_id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    $_SESSION['cart'] = array_values($_SESSION['cart']);

    header('Location: cart.php');
    exit();
}

if (isset($_GET['increase']) && isset($_SESSION['cart'])) {
    $increase_id = $_GET['increase'];

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $increase_id) {
            $item['product_quantity']++;
            break;
        }
    }

    header('Location: cart.php');
    exit();
}

if (isset($_GET['decrease']) && isset($_SESSION['cart'])) {
    $decrease_id = $_GET['decrease'];

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $decrease_id) {
            if ($item['product_quantity'] > 1) {
                $item['product_quantity']--;
            }
            break;
        }
    }

    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepetim - SenaHaven</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
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
            margin-top: auto;0
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

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        header nav ul li a:hover {
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-price {
            margin-top: 20px;
            font-weight: bold;
            text-align: right;
            font-size: 18px;
        }

        .buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .buttons button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-left: 10px;
        }

        .buttons button:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #000080;
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
        <h2>Sepetinizdeki Ürünler</h2>
        <div class="cart">
            <?php
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                $total_price = 0;
                echo '<form action="order_form.php" method="post">';
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Ürün Adı</th>';
                echo '<th>Fiyat (TL)</th>';
                echo '<th>Adet</th>';
                echo '<th>Toplam (TL)</th>';
                echo '<th>İşlem</th>'; 
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($_SESSION['cart'] as $item) {
                    $item_total = $item['product_price'] * $item['product_quantity'];
                    $total_price += $item_total;
                    echo '<tr>';
                    echo '<td>' . $item['product_name'] . '</td>';
                    echo '<td>' . $item['product_price'] . '</td>';
                    echo '<td>';
                    echo '<a href="cart.php?decrease=' . $item['product_id'] . '">- </a>';
                    echo $item['product_quantity'];
                    echo '<a href="cart.php?increase=' . $item['product_id'] . '"> +</a>';
                    echo '</td>';
                    echo '<td>' . $item_total . '</td>';
                    echo '<td><a href="cart.php?remove=' . $item['product_id'] . '">Sil</a></td>'; 
                    echo '<input type="hidden" name="products[]" value="' . $item['product_id'] . '">';
                    echo '<input type="hidden" name="quantities[]" value="' . $item['product_quantity'] . '">';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '<p class="total-price">Toplam Fiyat: ' . $total_price . ' TL</p>';
                echo '<div class="buttons">';
                echo '<button type="submit">Siparişi Tamamla</button>';
                echo '</form>';
                echo '<form action="empty_cart.php" method="post" style="display: inline;">';
                echo '<button type="submit">Sepeti Boşalt</button>';
                echo '</form>';
                echo '</div>';
            } else {
                echo '<p>Sepetinizde ürün bulunmamaktadır.</p>';
            }
            ?>
        </div>
    </main>
</body>

</html>
