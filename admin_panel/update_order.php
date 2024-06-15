<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = (int)$_POST['order_id'];
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $customer_email = $conn->real_escape_string($_POST['customer_email']);
    $shipping_address = $conn->real_escape_string($_POST['shipping_address']);
    $telephone_number = $conn->real_escape_string($_POST['telephone_number']);
    $total_amount = (float)$_POST['total_amount'];
    $order_date = $conn->real_escape_string($_POST['order_date']);

    $sql = "UPDATE orders 
            SET customer_name='$customer_name', customer_email='$customer_email', shipping_address='$shipping_address', telephone_number='$telephone_number', total_amount=$total_amount, order_date='$order_date' 
            WHERE order_id=$order_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Order updated successfully.</p>";
    } else {
        echo "<p>Error updating order: " . $conn->error . "</p>";
    }

    $conn->close();
    echo '<a href="order_list.php" class="btn">Return to the Order List</a>';
} else {
    echo "<p>Invalid request method.</p>";
}
?>