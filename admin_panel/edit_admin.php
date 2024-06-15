<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $admin_id = $_GET['admin_id'];

    $sql = "SELECT admin_name, admin_surname, admin_username, admin_status FROM admin_table WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $stmt->bind_result($admin_name, $admin_surname, $admin_username, $admin_status);
    $stmt->fetch();
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $admin_surname = $_POST['admin_surname'];
    $admin_username = $_POST['admin_username'];
    $admin_status = isset($_POST['admin_status']) ? 1 : 0;

    $sql = "UPDATE admin_table SET admin_name = ?, admin_surname = ?, admin_username = ?, admin_status = ? WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $admin_name, $admin_surname, $admin_username, $admin_status, $admin_id);

    if ($stmt->execute()) {
        $message = "Admin successfully updated.";
        $alert_class = "alert-success";
    } else {
        $message = "Error: " . $stmt->error;
        $alert_class = "alert-danger";
    }

    $stmt->close();
    $conn->close();

    echo "<div class='container mt-5'><div class='alert $alert_class' role='alert'>$message</div><a href='admin_list.php' class='btn btn-primary'>Return to the Admin List</a></div>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="checkout.css">
</head>

<body>

    <div class="container mt-5">
        <h2>Edit Admin</h2>

        <form method="post" action="">
            <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
            <div class="form-group">
                <label for="admin_name">Name:</label>
                <input type="text" class="form-control" id="admin_name" name="admin_name" value="<?php echo $admin_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="admin_surname">Surname:</label>
                <input type="text" class="form-control" id="admin_surname" name="admin_surname" value="<?php echo $admin_surname; ?>" required>
            </div>
            <div class="form-group">
                <label for="admin_username">Username:</label>
                <input type="text" class="form-control" id="admin_username" name="admin_username" value="<?php echo $admin_username; ?>" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="admin_status" name="admin_status" <?php echo $admin_status ? 'checked' : ''; ?>>
                <label class="form-check-label" for="admin_status">Admin Status</label>
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>

        <br>
        <a href="admin_list.php" class="btn btn-secondary">Return to the Admin List</a>
    </div>

</body>

</html>
