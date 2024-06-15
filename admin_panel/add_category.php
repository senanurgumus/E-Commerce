<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST['category_name'];
    $category_order = $_POST['category_order'];

    $sql = "INSERT INTO category_table (category_name, category_order) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $category_name, $category_order);

    if ($stmt->execute()) {
        echo "New Category Added Successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category</title>
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

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0 1rem 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
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
            background-color: #0056b3;
        }

        .btn:active {
            background-color: #004494;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-secondary:active {
            background-color: #4e555b;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add New Category</h2>
        <form action="" method="POST">
            <label for="category_name">Category Name:</label>
            <input type="text" id="category_name" name="category_name" required>
            <label for="category_order">Category Order:</label>
            <input type="number" id="category_order" name="category_order" required>
            <input type="submit" class="btn" value="Submit">
        </form>
        <br><br>
        <a href="dashboard.php" class="btn btn-secondary">Return to the Dashboard</a>
    </div>
</body>

</html>
