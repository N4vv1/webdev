<?php
include('../db/db.php');

// Get the product ID from the URL
$product_id = $_GET['id'];

// Fetch the product details from the database
$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// If the product is not found, show an error
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Product Details</title>

    <style>
        /* Custom Modal Styles */
        .modal-dialog {
            max-width: 800px;  /* Adjust the modal width */
            margin: 1.75rem auto;  /* Centers the modal horizontally and vertically */
        }

        .modal-content {
            padding: 20px;  /* Adds padding inside the modal */
        }

        .modal-header {
            display: flex;
            justify-content: center;
            text-align: center;
        }

        .modal-header h5 {
            text-align: center;  /* Centers the modal title */
        }

        .modal-body {
            display: flex;
            justify-content: center;  /* Center the content horizontally */
            align-items: center;  /* Center the content vertically */
            gap: 20px;  /* Adds space between image and text */
            text-align: left;
        }

        .modal-body .product-image {
            max-width: 250px;  /* Adjust the image size */
            flex-shrink: 0;  /* Prevents the image from shrinking */
        }

        .modal-body .product-details {
            max-width: 500px;  /* Limiting the width of the text part */
            flex-grow: 1;  /* Allow the text container to take up remaining space */
            overflow-wrap: break-word;  /* Ensures long words break to the next line */
            word-wrap: break-word;  /* Wraps long text */
            hyphens: auto;  /* Allows hyphenation for long words */
        }

        .product-details h5 {
            margin-top: 0;
        }

        .product-details p {
            font-size: 16px;
            white-space: normal;  /* Ensures the text wraps normally */
            word-break: break-word;  /* Breaks words if needed */
            overflow-wrap: break-word;
        }
    </style>
</head>
<body>

<!-- Modal content -->
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php echo $product['product_name']; ?></h5>
        </div>
        <div class="modal-body">
            <div class="product-image">
                <!-- Product Image -->
                <img src="<?php echo $product['image_url']; ?>" alt="Product Image" class="img-fluid">
            </div>
            <div class="product-details">
                <h5>Price: ₱ <?php echo number_format($product['price'], 2); ?></h5>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p><strong>Category:</strong> <?php echo $product['category']; ?></p>
                <p><strong>Stock:</strong> <?php echo $product['stock']; ?> items</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
