<!DOCTYPE html>
<html>

<head>
    <title>Order Deleted</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="checkout.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php
                include 'db_connect.php';

                $order_id = $_GET['id'];
                $message = "";
                $alert_class = "";

                $sql_delete_order = "DELETE FROM orders WHERE order_id = $order_id";
                if ($conn->query($sql_delete_order) === TRUE) {
                    $sql_delete_order_items = "DELETE FROM order_items WHERE order_id = $order_id";
                    if ($conn->query($sql_delete_order_items) === TRUE) {
                        $message = "Order deleted successfully.";
                        $alert_class = "alert-success";
                    } else {
                        $message = "Error deleting order items: " . $conn->error;
                        $alert_class = "alert-danger";
                    }
                } else {
                    $message = "Error deleting order: " . $conn->error;
                    $alert_class = "alert-danger";
                }

                $conn->close();
                ?>

                <?php if ($message): ?>
                    <div class="alert <?php echo $alert_class; ?>" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <a href="order_list.php" class="btn btn-primary">Return to the Orders</a>
            </div>
        </div>
    </div>
</body>

</html>
