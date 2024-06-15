<?php
session_start();

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : "";
$product_price = isset($_POST['product_price']) ? (float)$_POST['product_price'] : 0;
$product_quantity = isset($_POST['product_quantity']) ? (int)$_POST['product_quantity'] : 1;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$_SESSION['cart'][] = array(
    'product_id' => $product_id,
    'product_name' => $product_name,
    'product_price' => $product_price,
    'product_quantity' => $product_quantity
);

header('Location: cart.php');
exit;
?>
