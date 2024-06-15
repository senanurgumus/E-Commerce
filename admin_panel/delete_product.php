<?php
include 'db_connect.php';

$product_id = $_POST['product_id'];

try {
    $conn->begin_transaction();

    $sql = "DELETE FROM order_items WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo "Product deleted successfully.<br><br>";
    } else {
        echo "Error: " . $stmt->error . "<br><br>";
    }

    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    echo "Failed to delete product: " . $e->getMessage() . "<br><br>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product Deleted</title>
    <link rel="stylesheet" href="checkout.css">
</head>

<body>
    <a href="product_list.php" class="btn">Return to Product List</a>
</body>

</html>