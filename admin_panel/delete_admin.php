<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_id = $_POST['admin_id'];

    $sql = "DELETE FROM admin_table WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Preparation Error: " . $conn->error);
    }
    $stmt->bind_param("i", $admin_id);

    if ($stmt->execute()) {
        $message = "Admin successfully deleted.";
        $alert_class = "alert-success";
    } else {
        $message = "Error: " . $stmt->error;
        $alert_class = "alert-danger";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Deleted</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="checkout.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if (isset($message)): ?>
                    <div class="alert <?php echo $alert_class; ?>" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <a href="admin_list.php" class="btn btn-primary">Return to Admin List</a>
            </div>
        </div>
    </div>
</body>

</html>
