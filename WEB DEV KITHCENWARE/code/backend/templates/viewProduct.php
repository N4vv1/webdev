<?php
include('../db/db.php');

// Get the product ID from the URL
$product_id = $_GET['id'];

// Fetch the product details from the database
$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// If the product is not found, display an error
if (!$product) {
    echo "Product not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>View Product</title>
</head>
<body>

    <!-- Back Button -->
    <div class="container mt-4">
        <a href="productList.php" class="btn btn-secondary">Back to Product List</a>
    </div>

    <!-- Product Details -->
    <div class="container mt-4">
        <h1 class="text-center">Product Details</h1>
        <div class="row">
            <div class="col-md-4">
                <img src="../../<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="img-fluid">
            </div>
            <div class="col-md-8">
                <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
                <p><strong>Price:</strong> ₱ <?php echo number_format($product['price'], 2); ?></p>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                <p><strong>Stock:</strong> <?php echo $product['stock']; ?> items</p>
            </div>
        </div>
    </div>

</body>
</html>
