<?php
include 'db_connect.php';

$sql_categories = "SELECT * FROM category_table";
$result_categories = $conn->query($sql_categories);

if (isset($_POST['edit_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $stock_quantity = $_POST['stock_quantity'];
    $product_description = $_POST['product_description'];
    $category_id = $_POST['category_id'];

    if (!empty($_FILES['product_image']['name'])) {
        $file_name = $_FILES['product_image']['name'];
        $file_tmp = $_FILES['product_image']['tmp_name'];

        move_uploaded_file($file_tmp, "uploads/" . $file_name);
        $product_image_path = "uploads/" . $file_name;
        $sql_update_product = "UPDATE products SET product_name='$product_name', product_price='$product_price', stock_quantity='$stock_quantity', product_description='$product_description', category_id='$category_id', product_image='$product_image_path' WHERE product_id='$product_id'";

        if ($conn->query($sql_update_product) === TRUE) {
            $message = "Product Updated Successfully.";
            $alert_class = "alert-success";
        } else {
            $message = "Error: " . $sql_update_product . "<br>" . $conn->error;
            $alert_class = "alert-danger";
        }
    } else {
        $message = "Choose a new image.";
        $alert_class = "alert-warning";
    }
}

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $sql_get_product = "SELECT * FROM products WHERE product_id='$product_id'";
    $result_get_product = $conn->query($sql_get_product);
    $row = $result_get_product->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="checkout.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Product</h2>

        <?php if (isset($message)): ?>
            <div class="alert <?php echo $alert_class; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $row["product_id"]; ?>">
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $row["product_name"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_price">Price:</label>
                <input type="text" class="form-control" id="product_price" name="product_price" value="<?php echo $row["product_price"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity:</label>
                <input type="text" class="form-control" id="stock_quantity" name="stock_quantity" value="<?php echo $row["stock_quantity"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_description">Description:</label>
                <textarea class="form-control" id="product_description" name="product_description" required><?php echo $row["product_description"]; ?></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php
                    if ($result_categories->num_rows > 0) {
                        while ($category = $result_categories->fetch_assoc()) {
                            echo "<option value='" . $category["category_id"] . "'";
                            if ($category["category_id"] == $row["category_id"]) {
                                echo " selected";
                            }
                            echo ">" . $category["category_name"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="product_image">Choose an image:</label>
                <input type="file" class="form-control-file" id="product_image" name="product_image" required>
            </div>
            <button type="submit" class="btn btn-primary" name="edit_product">Update Product</button>
        </form>
        <br>
        <a href="product_list.php" class="btn btn-secondary">Return to the Product List</a>
    </div>
</body>

</html>
