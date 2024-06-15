<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

$message = "";
$alert_class = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_id'])) {
    $category_id = intval($_POST['category_id']);

    if ($conn) {
        $sql_delete_products = "DELETE FROM products WHERE category_id = ?";
        $stmt_delete_products = $conn->prepare($sql_delete_products);

        if ($stmt_delete_products) {
            $stmt_delete_products->bind_param("i", $category_id);
            if ($stmt_delete_products->execute()) {
                $sql_delete_category = "DELETE FROM category_table WHERE category_id = ?";
                $stmt_delete_category = $conn->prepare($sql_delete_category);

                if ($stmt_delete_category) {
                    $stmt_delete_category->bind_param("i", $category_id);
                    if ($stmt_delete_category->execute()) {
                        $message = "Category and associated products deleted successfully.";
                        $alert_class = "alert-success";
                    } else {
                        $message = "Error executing category delete query: " . $stmt_delete_category->error;
                        $alert_class = "alert-danger";
                    }
                    $stmt_delete_category->close();
                } else {
                    $message = "Error preparing category delete query: " . $conn->error;
                    $alert_class = "alert-danger";
                }
            } else {
                $message = "Error executing product delete query: " . $stmt_delete_products->error;
                $alert_class = "alert-danger";
            }
            $stmt_delete_products->close();
        } else {
            $message = "Error preparing product delete query: " . $conn->error;
            $alert_class = "alert-danger";
        }
        $conn->close();
    } else {
        $message = "Database connection failed.";
        $alert_class = "alert-danger";
    }
} else {
    $message = "Invalid request.";
    $alert_class = "alert-danger";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Category Deleted</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($message): ?>
                    <div class="alert <?php echo $alert_class; ?>" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <a href="category_list.php" class="btn btn-primary">Return to Category List</a>
            </div>
        </div>
    </div>
</body>
</html>
