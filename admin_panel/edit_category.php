<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    $sql = "SELECT category_name, category_order FROM category_table WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $category_name = $row['category_name'];
        $category_order = $row['category_order'];
    } else {
        echo "<div class='alert alert-danger' role='alert'>Category not found.</div>";
        exit();
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_category'])) {
    $category_name = $_POST['category_name'];
    $category_order = $_POST['category_order'];
    $category_id = $_POST['category_id'];

    $sql = "UPDATE category_table SET category_name = ?, category_order = ? WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $category_name, $category_order, $category_id);

    if ($stmt->execute()) {
        $message = "Category updated successfully.";
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
    <title>Edit Category</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Category</h2>

        <?php if (isset($message)): ?>
            <div class="alert <?php echo $alert_class; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
            <div class="form-group">
                <label for="category_name">Category Name:</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="category_order">Category Order:</label>
                <input type="number" class="form-control" id="category_order" name="category_order" value="<?php echo $category_order; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_category">Update</button>
        </form>
        <br>
        <a href="category_list.php" class="btn btn-secondary">Return to the Category List</a>
    </div>
</body>
</html>
