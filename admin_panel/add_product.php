<?php
include 'db_connect.php';

$sql_categories = "SELECT * FROM category_table";
$result_categories = $conn->query($sql_categories);

if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $stock_quantity = $_POST['stock_quantity'];
    $product_description = $_POST['product_description'];
    $category_id = $_POST['category_id'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($_FILES["product_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            echo "File Uploaded Successfully.";
        } else {
            echo "Error while uploading the file.";
            $uploadOk = 0;
        }
    }

    if ($uploadOk) {
        $stmt = $conn->prepare("INSERT INTO products (product_name, product_price, stock_quantity, product_description, category_id, product_image) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdisss", $product_name, $product_price, $stock_quantity, $product_description, $category_id, $target_file);

        if ($stmt->execute()) {
            echo "Product Added Successfully.";
        } else {
            echo "Error while adding the product: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="checkout.css">
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #333;
}

h2 {
    color: #5d5c61;
    text-align: center;
    margin-bottom: 20px;
}

form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 400px;
    max-width: 100%;
}

input[type="text"],
textarea,
select,
input[type="file"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"],
.btn {
    background-color: #5d5c61;
    color: white;
    padding: 10px 20px;
    margin: 10px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: block;
    width: 100%;
    text-align: center;
}

input[type="submit"]:hover,
.btn:hover {
    background-color: #6b686d;
}

a.btn {
    text-decoration: none;
    padding: 10px 1px;

}

a.btn:hover {
    background-color: #4a494d;
}

textarea {
    resize: vertical;
}

    </style>
</head>

<body>


    <form method="post" action="" enctype="multipart/form-data">
    <h2>Add Product</h2>

        Product Name: <input type="text" name="product_name" required><br>
        Price: <input type="text" name="product_price" required><br>
        Stock Quantity: <input type="text" name="stock_quantity" required><br>
        Description: <textarea name="product_description" required></textarea><br>
        Category:
        <select name="category_id" required>
            <?php
            if ($result_categories->num_rows > 0) {
                while ($row = $result_categories->fetch_assoc()) {
                    echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                }
            } else {
                echo "<option value=''>Categories not found.</option>";
            }
            ?>
        </select><br>
        Choose a File: <input type="file" name="product_image" required><br><br>
        <input type="submit" class="btn" name="add_product" value="Submit">
        <a href="dashboard.php" class="btn">Return to the Dashboard</a>

    </form>
</body>

</html>
