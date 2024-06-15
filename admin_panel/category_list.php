<?php
include 'db_connect.php';

$sql = "SELECT category_id, category_name, category_order FROM category_table";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .operations {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-secondary:active {
            background-color: #4e555b;
        }

        form {
            display: inline;
            margin: 0;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #c82333;
        }

        input[type="submit"]:active {
            background-color: #bd2130;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Category List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Order</th>
                <th>Operations</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["category_id"] . "</td>";
                    echo "<td>" . $row["category_name"] . "</td>";
                    echo "<td>" . $row["category_order"] . "</td>";
                    echo "<td class='operations'>";
                    echo "<form method='post' action='delete_category.php'><input type='hidden' name='category_id' value='" . $row["category_id"] . "'><input type='submit' value='Delete'></form>";
                    echo "<form method='get' action='edit_category.php'><input type='hidden' name='category_id' value='" . $row["category_id"] . "'><input type='submit' value='Edit'></form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Can't find Category</td></tr>";
            }
            ?>
        </table>
        <br>
        <a href="dashboard.php" class="btn btn-secondary">Return to Dashboard</a>
    </div>

    <?php
    $conn->close();
    ?>
</body>

</html>
