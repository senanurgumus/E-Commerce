<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Bilgileri - SenaHaven</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
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

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .contact-info {
            margin-bottom: 20px;
        }

        .contact-info p {
            margin-bottom: 10px;
        }

        .contact-info p:last-child {
            margin-bottom: 0;
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
    <div class="container">
        <h1>İletişim Bilgileri</h1>
        <div class="contact-info">
            <p><strong>Adres:</strong>  Cumhuriyet Mah. 2253 Sok. No: 13, Ataşehir, İstanbul, Türkiye </p>
            <p><strong>Telefon:</strong> +90 262 572 6872</p>
            <p><strong>E-posta:</strong> info@senahaven.com</p>
        </div>
        <p>İletişim için yukarıda yer alan bilgileri kullanabilirsiniz.</p>
    </div>

    <footer>
        <p>2024 - SenaHaven.com</p>
    </footer>
</body>

</html>