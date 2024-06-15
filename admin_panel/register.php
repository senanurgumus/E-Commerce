<?php
include 'db_connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Kullanıcı başarıyla oluşturuldu.";
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kayıt Ol</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .register-container h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }

        .register-container form {
            display: flex;
            flex-direction: column;
        }

        .register-container label {
            margin-bottom: 8px;
        }

        .register-container input[type="text"],
        .register-container input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .register-container input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .register-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .register-container a {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

    </style>
</head>
<body>
    <div class="register-container">
        <h2>Kayıt Ol</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username">
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password">
            <input type="submit" value="Kayıt Ol">
        </form><br>
        <a href="user_login.php">Geri Dön</a>
    </div>

</body>