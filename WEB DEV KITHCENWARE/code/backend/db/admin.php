<?php include('db.php'); 
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    // Redirect non-admin users to the homepage or another page
    header('Location: homepage.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>K Depot</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Dashboard</h1>

        <!-- Dashboard Summary Section -->
        <div class="row text-center">
    <!-- Merged Total Products and Out of Stock Products -->
    <div class="col-md-6 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <?php
                $productCount = $conn->query("SELECT COUNT(*) AS count FROM products")->fetch_assoc()['count'];
                $outOfStock = $conn->query("SELECT COUNT(*) AS count FROM products WHERE stock = 0")->fetch_assoc()['count'];
                ?>
                <h3 class="card-title">Total Products: <?php echo $productCount; ?></h3>
                <p class="card-text">
                    Out of Stock: <?php echo $outOfStock; ?>
                </p>
                <a href="../templates/productList.php" class="btn btn-light btn-sm">Manage Inventory</a>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="col-md-6 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <?php
                $orderCount = $conn->query("SELECT COUNT(*) AS count FROM cart")->fetch_assoc()['count'];
                ?>
                <h3 class="card-title">Total Orders: <?php echo $orderCount; ?></h3>
                <p class="card-text">Total Orders</p>
                <a href="../templates/orderList.php" class="btn btn-light btn-sm">Manage Orders</a>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>

    <footer class="text-center mt-5">
        <p>&copy; <?php echo date("Y"); ?> Kitchen Nadal Admin Dashboard</p>
    </footer>
</body>
</html>
