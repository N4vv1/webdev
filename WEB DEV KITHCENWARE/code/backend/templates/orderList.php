<?php
include('../db/db.php'); 

// Initialize filters
$date_filter = "";
$status_filter = "";
$customer_filter = "";

// Check if form is submitted to filter orders
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['date'])) {
        $date_filter = $_POST['date'];
        $date_filter = " AND cart.created_at LIKE '%$date_filter%'";
    }
    if (!empty($_POST['status'])) {
        $status_filter = $_POST['status'];
        $status_filter = " AND cart.status = '$status_filter'";
    }
    if (!empty($_POST['customer'])) {
        $customer_filter = $_POST['customer'];
        $customer_filter = " AND (user_info.first_name LIKE '%$customer_filter%' OR user_info.last_name LIKE '%$customer_filter%')";
    }
}

// SQL query with dynamic filters
$sql = "SELECT cart.*, user_info.first_name, user_info.middle_name, user_info.last_name, user_info.email
        FROM cart
        JOIN user_info ON cart.user_id = user_info.user_id
        WHERE 1=1" . $date_filter . $status_filter . $customer_filter;

// Execute the query
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Order Management</title>
</head>
<body>

    <!-- Back Button to Admin Dashboard -->
    <div class="container mt-4">
        <a href="../db/admin.php" class="btn btn-secondary">Back</a>
    </div>

    <!-- Search and Filtering Form -->
    <div class="container mt-4">
        <h2>Search Orders</h2>
        <form method="POST" action="">
            <div class="row">
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" placeholder="Order Date" value="<?php echo $date_filter; ?>">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Pending" <?php echo $status_filter == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Shipped" <?php echo $status_filter == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                        <option value="Delivered" <?php echo $status_filter == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="customer" class="form-control" placeholder="Customer Name" value="<?php echo $customer_filter; ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container mt-5">
        <h1>Order Management</h1>
        
        <!-- Table of Orders -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Order Placed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if any orders were found
                if ($result->num_rows > 0) {
                    // Display the orders in the table  
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['cart_id']}</td>
                                <td>{$row['first_name']} {$row['middle_name']} {$row['last_name']}</td>
                                <td>{$row['email']}</td>
                                <td>₱ {$row['price']}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['payment_status']}</td>
                                <td>{$row['created_at']}</td>
                                <td>
                                    <a href='updateOrder.php?cart_id={$row['cart_id']}&status=Shipped' class='btn btn-sm btn-warning'>Mark as Shipped</a>
                                    <a href='updateOrder.php?cart_id={$row['cart_id']}&status=Delivered' class='btn btn-sm btn-success'>Mark as Delivered</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
