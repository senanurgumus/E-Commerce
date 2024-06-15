<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_name = $_POST['admin_name'];
    $admin_surname = $_POST['admin_surname'];
    $admin_username = $_POST['admin_username'];
    $admin_pass = $_POST['admin_pass'];
    $admin_status = isset($_POST['admin_status']) ? 1 : 0;

    $sql = "INSERT INTO admin_table (admin_name, admin_surname, admin_username, admin_pass, admin_status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $admin_name, $admin_surname, $admin_username, $admin_pass, $admin_status);

    if ($stmt->execute()) {
        echo "New admin created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-bottom: 1.5rem;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0 1rem 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .btn {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            padding: 0.5rem 1rem;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
        }

        .btn:hover {
            background-color: #218838;
        }

        .btn:active {
            background-color: #1e7e34;
        }

        .btn-secondary {
            background-color: #007bff;
        }

        .btn-secondary:hover {
            background-color: #0069d9;
        }

        .btn-secondary:active {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Admin</h2>
        <form method="post" action="">
            <label for="admin_name">Name:</label><br>
            <input type="text" id="admin_name" name="admin_name" required><br>
            <label for="admin_surname">Surname:</label><br>
            <input type="text" id="admin_surname" name="admin_surname" required><br>
            <label for="admin_username">Username:</label><br>
            <input type="text" id="admin_username" name="admin_username" required><br>
            <label for="admin_pass">Password:</label><br>
            <input type="password" id="admin_pass" name="admin_pass" required><br>
            <label for="admin_status">Admin Status:</label><br>
            <input type="checkbox" id="admin_status" name="admin_status"><br><br>
            <input type="submit" class="btn" value="Submit">
        </form>
        <br><br>
        <a href="dashboard.php" class="btn btn-secondary">Return to the Dashboard</a>
    </div>
</body>

</html>
